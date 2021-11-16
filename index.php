<?php

session_start();

if (isset($_SESSION['logged_in'])) {
  // if logged in do something optional here
}

// Setting the page and language type
$page = "home";

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
    <style media="screen">
      .title-block {
        background-color: lightgray;
        height: 21vh;
        width: 100%;
      }
      .home-title {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        font-size: 1.5em;
        font-weight: 700;
        padding: 20px;
      }
      .content-spacer {
        height: 4.5vh;
      }
      .content-block {
        display: flex;
        height: 42vh;
        width: 100%;
      }
      .one-third {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        width: calc(calc(100% / 3) - 40px);
        padding: 20px;
      }
      .one-third a {
        flex-grow: 1;
      }
      .two-thirds {
        width: calc(calc(100% / 3) * 2);
      }
      .two-thirds img {
        overflow: hidden;
        object-fit: cover;
        width: 100%;
        height: 100%;
      }
      .half {
        display: flex;
        width: 50%;
      }
    </style>
  </head>
  <body>

    <!-- START HEADER -->

    <?php include_once 'shared/header.php'; ?>

    <!-- END HEADER | START BODY -->

    <div class="main-content">
      <div class="title-block">
        <div class="two-thirds">
          <div class="home-title">
            <h2>The osservatorio d'arte Venezia welcomes you!</h2>
            <h4>Here you can find details on art locations of cultural signifigance
            and the events that take place at them.</h4>
          </div>
        </div>
        <div class="one-third">
          <div class="">

          </div>
          <a href="map.php" style="flex-grow: 0;">
            <h3>Explore our map of locations and events! ➔</h3>
          </a>
        </div>
      </div>
      <div class="content-block">
          <div class="one-third" style="background-color: #1dcdef;">
            <a href="#exhibit-loc">
              <h1>EXHIBITIONS</h1>
            </a>
            <div class="link-options">
              <a href="#exhibit-loc">
                <h3>Explore exhibition locations ➔</h3>
              </a>
              <a href="#exhibit-event">
                <h3>Explore events ➔</h3>
              </a>
            </div>
          </div>
          <a href="#exhibit-loc"class="two-thirds">
            <img src="images\home\exhibit.jpg" alt="Picture of Murano glass">
          </a>
        </a>
      </div>
      <div class="content-block">
        <a href="#exhibit-loc"class="two-thirds">
          <img src="images\home\perform.jpg" alt="Picture of a performer on stage">
        </a>
        <div class="one-third" style="background-color: #b32d14;">
          <a href="#exhibit-loc">
            <h1>PERFORMANCES</h1>
          </a>
          <div class="link-options">
            <a href="#exhibit-loc">
              <h3>Explore performing locations ➔</h3>
            </a>
            <a href="#exhibit-event">
              <h3>Explore events ➔</h3>
            </a>
          </div>
        </div>
      </div>
      <div class="content-spacer">

      </div>
      <div class="content-block">
        <div class="half" style="background-color: red;">
          <div class="one-third" style="background-color: #a1ccb0;">
            <a href="#museum-loc">
              <h1>MUSEUMS</h1>
            </a>
            <div class="link-options">
              <a href="#museum-loc">
                <h3>Explore locations ➔</h3>
              </a>
              <a href="#museum-event">
                <h3>Explore events ➔</h3>
              </a>
            </div>
          </div>
          <a href="#museum-loc" class="two-thirds">
            <img src="images\home\museum.jpg" alt="Picture of Doge's Palace">
          </a>
        </div>
        <div class="half" style="background-color: blue;">
          <div class="one-third" style="background-color: #e1ae8c;">
            <a href="#gallery-loc">
              <h1>GALLERIES</h1>
            </a>
            <div class="link-options">
              <a href="#gallery-loc">
                <h3>Explore locations ➔</h3>
              </a>
              <a href="#gallery-event">
                <h3>Explore events ➔</h3>
              </a>
            </div>
          </div>
          <a href="#gallery-loc" class="two-thirds">
            <img src="images\home\gallery.jpg" alt="Picture of a man looking at a painting">
          </a>
        </div>
      </div>
      <div class="content-block">
        <div class="half" style="background-color: purple;">
          <a href="#theatre-loc" class="two-thirds">
            <img src="images\home\theatre.jpg" alt="Picture of theatre performers">
          </a>
          <div class="one-third" style="background-color: pink;">
            <a href="#theatre-loc">
              <h1>THEATRES</h1>
            </a>
            <div class="link-options">
              <a href="#theatre-loc">
                <h3>Explore locations ➔</h3>
              </a>
              <a href="#theatre-event">
                <h3>Explore events ➔</h3>
              </a>
            </div>
          </div>
        </div>
        <div class="half" style="background-color: orange;">
          <a href="#opera-loc" class="two-thirds">
            <img src="images\home\opera.jpg" alt="Picture of the Sydney Opera House">
          </a>
          <div class="one-third" style="background-color: #0497cf;">
            <a href="#opera-loc">
              <h1>OPERA HOUSES</h1>
            </a>
            <div class="link-options">
              <a href="#opera-loc">
                <h3>Explore locations ➔</h3>
              </a>
              <a href="#opera-event">
                <h3>Explore events ➔</h3>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!--
      <div class="title-block">
        <div class="title">
          CULTURAL VENUES OF VENICE
        </div>
        <div class="description">
          Little description here
        </div>
      </div>
      <div class="auto-generated">
        <div class="home-box">
          <a href="search.php?search=exhibitions">
            <img src="images/icons/home_exhibitions.PNG" alt="Exhibition Link Logo">
          </a>
        </div>
        <div class="home-box">
          <a href="search.php?search=performances">
            <img src="images/icons/home_performances.PNG" alt="Performances Link Logo">
          </a>
        </div>
        <div class="home-box">
          <a href="search.php?search=theatres">
            <img src="images/icons/home_theatres.PNG" alt="Theatre Link Logo">
          </a>
        </div>
        <div class="home-box">
          <a href="search.php?search=music">
            <img src="images/icons/home_music.PNG" alt="Music Link Logo">
          </a>
        </div>
        <div class="home-box">
          <a href="search.php?search=workshops">
            <img src="images/icons/home_workshops.PNG" alt="Workshops Link Logo">
          </a>
        </div>
        <div class="home-box">
          <a href="search.php?search=other">
            <img src="images/icons/home_other.PNG" alt="Other Section Link Logo">
          </a>
        </div>
      </div> -->
    </div>

    <!-- END BODY | START FOOTER -->

    <?php include_once 'shared/footer.php'; ?>

    <!-- END FOOTER | START JAVASCRIPT -->

  <script type="text/javascript">
    // write script here if we so choose
  </script>
</html>
