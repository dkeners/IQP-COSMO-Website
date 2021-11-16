<?php

// Setting the page and language type
$page = "search";

// Set the engine to catch no errors
set_error_handler(function() { /* ignore errors */ });

// determine the language of the page to display, default
if ($_GET['lang'] == "it" || $_POST['lang'] == "it") {
  $lang = "it";
} else {
  $lang = "en";
}

// Everything should be caught after here
restore_error_handler();

if (isset($_POST['type'])) {
  switch ($_POST['type']) {
    case 'venues':
      // code...
      break;

    default:
      // code...
      break;
  }
}

?>

<!DOCTYPE html>
<html lang=" <?php echo $lang ?> " dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>osservatorio d'arte Venezia</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Playfair+Display:ital@0;1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/searchbar.css">
    <style media="screen">
      /* End searchy Stuffs */
      .box-container {
        background-color: lightgray;
        width: 26%;
        max-height: 30%;
      }
      .box-container-img {
        width: 100%;
        height: 30%;
      }
      .box-container-img img {
       overflow: hidden;
       object-fit: cover;
       width: 100%;
       height: 100%;
     }
    </style>
  </head>
  <body onclick="showResult('')">

    <!-- START HEADER -->

    <?php include_once 'shared/header.php'; ?>

    <!-- END HEADER | START BODY -->

    <div class="main-content">
      <div class="title-block">
        <div id="searchBarWrapper">
            <!--SEARCH PANEL STRUCTURE-->
            <div id="searchClick">
              <div class='searchBar' onblur="showResult('')">
                  <input type='text' id='searchTextField' placeholder="Search by Name or Keyword..."  onkeyup="showResult(this.value)"></input>
                  <button id='searchButton' onclick="updateResults('reqType=search')">SEARCH</button>
              </div>
              <div id="livesearch"></div>
            </div>
            <!--Venue/Event PANEL STRUCTURE-->
            <div id='datePanel'>
              <div data-state='disabled' class='categoryCheckbox CC_disabled' id='venues_checkbox' onclick='toggleCheckbox(id)'>Venues</div>
              <div data-state='disabled' class='categoryCheckbox CC_disabled' id='events_checkbox' onclick='toggleCheckbox(id)'>Events</div>
              <div data-state='disabled' class='categoryCheckbox CC_disabled' id='options_checkbox' onclick='toggleOptions(this)'>More Options</div>
            </div>
            <div class="extraSearchOptions hidden" id="expandableSearchBar">
              <div class="hidden" id="eventsOptions">
                <!--DATE PANEL STRUCTURE-->
                <div id='datePanel'>
                    <input class='dateField' type='date' id='fromDate'></input>
                    <label id='datePanelToLabel'>To</label>
                    <input class='dateField' type='date' id='toDate'></input>
                </div>
                <!--CATEGORY PANEL STRUCTURE-->
                <div class='categoryPanel'>
                    <div data-state='disabled' class='categoryCheckbox CC_disabled' id='evenice_1_checkbox' onclick='toggleCheckbox(id)'>evenice_1</div>
                    <div data-state='disabled' class='categoryCheckbox CC_disabled' id='evenice_2_checkbox' onclick='toggleCheckbox(id)'>evenice_2</div>
                    <div data-state='disabled' class='categoryCheckbox CC_disabled' id='evenice_3_checkbox' onclick='toggleCheckbox(id)'>evenice_3</div>
                    <div data-state='disabled' class='categoryCheckbox CC_disabled' id='evenice_4_checkbox' onclick='toggleCheckbox(id)'>evenice_4</div>
                </div>
              </div>
              <div class="hidden" id="venueOptions">
                <!--CATEGORY PANEL STRUCTURE-->
                <div class='categoryPanel'>
                    <div data-state='disabled' class='categoryCheckbox CC_disabled' id='galleries_checkbox' onclick='toggleCheckbox(id)'>Galleries</div>
                    <div data-state='disabled' class='categoryCheckbox CC_disabled' id='museums_checkbox' onclick='toggleCheckbox(id)'>Museums</div>
                    <div data-state='disabled' class='categoryCheckbox CC_disabled' id='theatres_checkbox' onclick='toggleCheckbox(id)'>Theatres</div>
                    <div data-state='disabled' class='categoryCheckbox CC_disabled' id='opera_checkbox' onclick='toggleCheckbox(id)'>Opera Houses</div>
                </div>
              </div>
            </div>
          </div>
        <!-- <div class="title">
          <form>
            <input type="text" size="30" onkeyup="showResult(this.value)">
            <div id="livesearch"></div>
          </form>
        </div>
        <div class="description">

        </div> -->
      </div>
      <div class="auto-generated" id="resultsDisplayArea">
        <!-- DEV ##################### -->
        <div class="box-container">
          <h1>loc/event name</h1>
          <h2>loc/event location</h2>
          <div class="box-container-img">
            <img src="images\home\exhibit.jpg" alt="Picture of loc/event">
          </div>
          <h2>description here</h2>
          <div class="box-links">
            more links here
          </div>
        </div>
        <!-- DEV ##################### -->
        <div class="box-container">
          <h1>loc/event name</h1>
          <h2>loc/event location</h2>
          <div class="box-container-img">
            <img src="images\home\exhibit.jpg" alt="Picture of loc/event">
          </div>
          <h2>description here</h2>
          <div class="box-links">
            more links here
          </div>
        </div>
        <div class="box-container">
          <h1>loc/event name</h1>
          <h2>loc/event location</h2>
          <div class="box-container-img">
            <img src="images\home\exhibit.jpg" alt="Picture of loc/event">
          </div>
          <h2>description here</h2>
          <div class="box-links">
            more links here
          </div>
        </div>
        <div class="box-container">
          <h1>loc/event name</h1>
          <h2>loc/event location</h2>
          <div class="box-container-img">
            <img src="images\home\exhibit.jpg" alt="Picture of loc/event">
          </div>
          <h2>description here</h2>
          <div class="box-links">
            more links here
          </div>
        </div>
      </div>
    </div>

    <!-- END BODY | START FOOTER -->

    <?php include_once 'shared/footer.php'; ?>

    <!-- END FOOTER | START JAVASCRIPT -->
  <script src="js\liveSearchFunc.js" charset="utf-8"></script>
  <script>
    // XML HTTP CODE
    function getDB(params = 'reqType=search&limit=50', addMore = false) {
        const xhttp = new XMLHttpRequest();
        xhttp.open('POST', 'searchFunc.php', true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.onload = function(){
          if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            var response = xhttp.responseText
            // var JSONData = JSON.parse(response)

            // change results
            var resultsDisp = document.getElementById('resultsDisplayArea');
            if (addMore) {
              resultsDisp.innerHTML += response;
            } else {
              resultsDisp.innerHTML = response;
            }

          } else {
            alert('Request failure.');
          }
        }

        xhttp.send(params);

    }
  </script>
</html>
