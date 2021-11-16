<?php

require_once 'config.php';

$clause = array();
$snum = '';
$varArray = array();

// SETTING UP VARIABLES FOR EACH OF THE INPUTS
// Searching based on words similar in titles and descriptions
if (isset($_POST['title'])) {
  $clause[] = "Name_IT LIKE CONCAT(?, '%') OR Name_EN LIKE CONCAT('% ', ?, '%')";
  $snum .= 'ss';
  $varArray[] = $_POST['title'];
  $varArray[] = $_POST['title'];
}
if (isset($_POST['keyword'])) {
  $clause[] = "Name_IT LIKE CONCAT('%', ?, '%') OR Name_EN LIKE CONCAT('%', ?, '%') OR Description_IT LIKE CONCAT('%', ?, '%') OR Description_EN LIKE CONCAT('%', ?, '%')";
  $snum .= 'ssss';
  $varArray[] = $_POST['keyword'];
  $varArray[] = $_POST['keyword'];
  $varArray[] = $_POST['keyword'];
  $varArray[] = $_POST['keyword'];
}
// Our overarching genres here:
if (isset($_POST['Performance'])) {
  $clause[] = "Performance = 1";
}
if (isset($_POST['Exhibit'])) {
  $clause[] = "Exhibit = 1";
}
// Sub Genres Here:
if (isset($_POST['Gallery'])) {
  $clause[] = "Type = 'Gallery'";
}
if (isset($_POST['Theatre'])) {
  $clause[] = "Type = 'Theatre'";
}
if (isset($_POST['Opera'])) {
  $clause[] = "Type = 'Opera'";
}
if (isset($_POST['Museum'])) {
  $clause[] = "Type = 'Museum'";
}
// Setting the limit of requests
$limitSTR = '';
if (isset($_POST['limit'])) {
  $limitSTR .= ' LIMIT ?';
  $snum .= 's';
  $varArray[] = $_POST['limit'];
}

// CREATING THE REQUEST STRING FROM INPUTS
// Turn the array into a single string
$whereSTR = implode(' OR ', $clause);

// If the array wasn't empty, and a string was made, add 'WHERE' to the front
if ($whereSTR != '') {
  $whereSTR = ' WHERE ' . $whereSTR;
}
// If a limit is stated add to the clause.
if ($limitSTR != '') {
  $whereSTR .= $limitSTR;
}

// CREATE REQUESTS FOR EACH UNIQUE CASE: LIVE, MAP, OR SEARCH
// The first request is for the live searchbar feed
if ($_POST['reqType'] == 'live') {
  // lookup top ten matches from the database if length of keyword > 0
  // the keyword should always be > 0, if not the request fails.
  if (strlen($_POST['title']) > 0) {
    if ($stmt = $con->prepare(('SELECT * FROM locationdata' . $whereSTR . ";"))) {
      if ($snum != '') {
        $stmt->bind_param($snum, ...$varArray);
      }

      $stmt->execute();

      $result = $stmt->get_result();

      $hint="";
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          if ($hint=="") {
            $hint = "<a href='#' onclick='selectSuggestion(this)'>" .
            (($row['Name_EN'] != '') ? $row['Name_EN'] : $row['Name_IT'])
            . "</a>";
          } else {
            $hint = $hint . "<br /><a href='#' onclick='selectSuggestion(this)'>" .
            (($row['Name_EN'] != '') ? $row['Name_EN'] : $row['Name_IT'])
            . "</a>";
          }
        }
      }

      $stmt->close();
    }

    // Set output to "no suggestion" if no hint was found
    // or to the correct values
    if ($hint == "") {
      $response = "No suggestions";
    } else {
      $response = $hint;
    }

    //output the response
    echo $response;
    die;

  } else {
    echo "Live Search Request Failed:<br />";
    http_response_code(400);
    die;
  }
} elseif ($_POST['reqType'] == 'map') {
  if ($stmt = $con->prepare(('SELECT * FROM locationdata' . $whereSTR . ';'))) {
    if ($snum != '') {
      $stmt->bind_param($snum, ...$varArray);
    }

    $stmt->execute();

    $result = $stmt->get_result();

    $resultsArray = array();

    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $resultsArray[] = $row;
      }
    }

    $stmt->close();

    echo json_encode($resultsArray);
    die;
  }
} elseif ($_POST['reqType'] == 'search') {
    if ($stmt = $con->prepare(('SELECT * FROM locationdata' . $whereSTR . ';'))) {
      if ($snum != '') {
        $stmt->bind_param($snum, ...$varArray);
      }

      $stmt->execute();

      $result = $stmt->get_result();

      $resultsArray = array();

      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $resultsArray[] = $row;
        }
      }

      $stmt->close();

      echo "<div class='box-container'>
        <h1>loc/event name</h1>
        <h2>loc/event location</h2>
        <div class='box-container-img'>
          <img src='images\home\\exhibit.jpg' alt='Picture of loc/event'>
        </div>
        <h2>description here</h2>
        <div class='box-links'>
          more links here
        </div>
        </div>";
      die;
  } else {
    echo "Search Request Failed:<br />";
    echo "stmt: " . $stmtText;
    http_response_code(400);
    die;
  }
} else {
  echo "No Valid reqType Provided";
  http_response_code(400);
  die;
}


?>
