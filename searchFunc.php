<?php

session_start();

require_once 'config.php';

$clause = array();
$snum = '';
$varArray = array();

// Setting table the request is coming from
if (isset($_POST['table'])) {
  switch ($_POST['table']) {
    case 'location':
      $table = 'locationdata';
      break;
    case 'event':
      $table = 'eventdata';
      break;
    case 'assoc':
      $table = 'assocdata';
      break;
    default:
      $table = 'locationdata';
      break;
  }
} else {
  $table = 'locationdata';
}

// SETTING UP VARIABLES FOR EACH OF THE INPUTS
// Searching based on words similar in titles and descriptions
if (isset($_POST['title'])) {
  $clause[] = "name_IT LIKE CONCAT(?, '%') OR name_EN LIKE CONCAT('% ', ?, '%')";
  $snum .= 'ss';
  $varArray[] = $_POST['title'];
  $varArray[] = $_POST['title'];
}
if (isset($_POST['keyword'])) {
  $clause[] = "name_IT LIKE CONCAT('%', ?, '%') OR name_EN LIKE CONCAT('%', ?, '%') OR description_IT LIKE CONCAT('%', ?, '%') OR description_EN LIKE CONCAT('%', ?, '%')";
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
// // Sub Genres Here:
// if (isset($_POST['Gallery'])) {
//   $clause[] = "Type = 'Gallery'";
// }
// if (isset($_POST['Theatre'])) {
//   $clause[] = "Type = 'Theatre'";
// }
// if (isset($_POST['Opera'])) {
//   $clause[] = "Type = 'Opera'";
// }
// if (isset($_POST['Museum'])) {
//   $clause[] = "Type = 'Museum'";
// }

// Setting DATE LIMITS
if (isset($_POST['start']) && isset($_POST['end'])) {
  $clause[] = "start_date BETWEEN ? AND ? OR end_date BETWEEN ? AND ?";
  $snum .= 'ssss';
  $varArray[] = $_POST['start'];
  $varArray[] = $_POST['end'];
  $varArray[] = $_POST['start'];
  $varArray[] = $_POST['end'];
} elseif (isset($_POST['start'])) {
  // big date in the future
  $clause[] = "start_date BETWEEN ? AND 2100-01-01 OR end_date BETWEEN ? AND 2100-01-01";
  $snum .= 'ss';
  $varArray[] = $_POST['start'];
  $varArray[] = $_POST['start'];
} elseif (isset($_POST['start'])) {
  // date just before the very first point of our database records
  $clause[] = "start_date BETWEEN 2015-01-01 AND ? OR end_date BETWEEN 2015-01-01 AND ?";
  $snum .= 'ss';
  $varArray[] = $_POST['end'];
  $varArray[] = $_POST['end'];
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
  $reqSTR = $table . ' WHERE ' . $whereSTR;
} else {
  $reqSTR = $table;
}
// If a limit is stated add to the clause.
if ($limitSTR != '') {
  $reqSTR .= $limitSTR;
}


// CREATE REQUESTS FOR EACH UNIQUE CASE: LIVE, MAP, OR SEARCH

// The first request is for the live searchbar feed
if ($_POST['reqType'] == 'live') {
  // lookup top ten matches from the database if length of keyword > 0
  // the keyword should always be > 0, if not the request fails.
  if (strlen($_POST['title']) > 0) {
    if ($stmt = $con->prepare(('SELECT * FROM ' . $reqSTR . ";"))) {
      if ($snum != '') {
        $stmt->bind_param($snum, ...$varArray);
      }

      $stmt->execute();

      $result = $stmt->get_result();

      $hint="";
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $hint .= "<a href='#' onclick='selectSuggestion(this)'>" .
          (($row['name_EN'] != '') ? $row['name_EN'] : $row['name_IT'])
          . "</a><br />";
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
  if ($stmt = $con->prepare(('SELECT * FROM ' . $reqSTR . ';'))) {
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
    if ($stmt = $con->prepare(('SELECT * FROM ' . $reqSTR . ';'))) {
      if ($snum != '') {
        $stmt->bind_param($snum, ...$varArray);
      }

      $stmt->execute();

      $result = $stmt->get_result();

      $resultHTML = "";

      if ($table == 'locationdata') {
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
          echo  "<div class='box-container'>
                  <h1>" . $row['name_IT'] . "</h1>
                  <h2>" . $row['address'] . "</h2>
                  <div class='box-container-img'>
                    <img src='images\home\\exhibit.jpg' alt='Picture of loc/event'>
                  </div>
                  <h2>" . $row['description_IT'] . "</h2>
                  <div class='box-links'>
                    more links here
                  </div>" .
                  ((isset($_SESSION['logged_in'])) ?
                  "<div class='box-links'>
                    <form class='' action='manageData.php' method='post'>
                      <input type='hidden' name='edit' value='location'>
                      <input type='hidden' name='id' value='" . $row['id'] . "'>
                      <button type='submit' name='submit'>EDIT</button>
                    </form>
                    <form class='' action='adminFunc.php' method='post'>
                      <input type='hidden' name='delete' value='location'>
                      <input type='hidden' name='id' value='" . $row['id'] . "'>
                      <button type='submit' name='submit'>DELETE</button>
                    </form>
                  </div>" : "" ) . "
                 </div>";
          }
        }
      } elseif ($table == 'eventdata') {
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
          echo  "<div class='box-container'>
                  <h1>" . $row['event_name'] . "</h1>
                  <h2>" . $row['location_name'] . "</h2>
                  <div class='box-container-img'>
                    <img src='images\home\\exhibit.jpg' alt='Picture of loc/event'>
                  </div>
                  <h2>" . $row['start_date'] . " to " . $row['end_date'] . "</h2>
                  <div class='box-links'>
                    more links here
                  </div>" .
                  ((isset($_SESSION['logged_in'])) ?
                  "<div class='box-links'>
                    <form class='' action='manageData.php' method='post'>
                      <input type='hidden' name='edit' value='event'>
                      <input type='hidden' name='id' value='" . $row['id'] . "'>
                      <button type='submit' name='submit'>EDIT</button>
                    </form>
                    <form class='' action='adminFunc.php' method='post'>
                      <input type='hidden' name='delete' value='event'>
                      <input type='hidden' name='id' value='" . $row['id'] . "'>
                      <button type='submit' name='submit'>DELETE</button>
                    </form>
                  </div>" : "" ) . "
                 </div>";
          }
        }
      }

      $stmt->close();

      die;
  } else {
    echo "Search Request Failed:<br />";
    echo "stmt: " . $reqSTR;
    http_response_code(400);
    die;
  }
} else {
  echo "No Valid reqType Provided";
  http_response_code(400);
  die;
}


?>
