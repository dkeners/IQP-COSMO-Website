<?php

// Setting the language of the menu
if ($lang == "it") {
  $homeLabel = "Home";
  $searchLabel = "Ricerca";
  $mapLabel = "Carta";
  $aboutLabel = "About";
} else {
  $homeLabel = "Home";
  $searchLabel = "Search";
  $mapLabel = "Map";
  $aboutLabel = "About";
}

// Setting default links for the sites
$homeLink = "index.php";
$mapLink = "map.php";
$searchLink = "search.php";
$aboutLink = "about.php";

// Set current page to a null link to avoid useless reloads
switch ($page) {
  case 'home':
    $homeLink = "#";
    break;
  case 'map':
    $mapLink = "#";
    break;
  case 'search':
    $searchLink = "#";
    break;
  case 'about':
    $aboutLink = "#";
    break;
  default:
    // do nothing if on a page thats not on our menu
    break;
}

?>

<!-- HTML for the page header so that it is placed in the original document
     with the variables changed by php. -->
<div class='header'>
  <div class="header-menu">
    <a href='<?php echo $homeLink; ?>' style='margin-left: 0px; float: left;'><img src='images/icons/logo.PNG' alt='OAV Logo' style='height: 7vh; float: left;'></a>
    <a href='<?php echo $homeLink; ?>' style='float: left;'><h2>osservatorio d'arte Venezia</h2></a>
  </div>
  <div class='header-menu'>
    <a href='<?php echo $homeLink; ?>'><h3><?php echo $homeLabel; ?></h3></a>
    <a href='<?php echo $searchLink; ?>'><h3><?php echo $searchLabel; ?></h3></a>
    <a href='<?php echo $mapLink; ?>'><h3><?php echo $mapLabel; ?></h3></a>
    <a href='<?php echo $aboutLink; ?>'><h3><?php echo $aboutLabel; ?></h3></a>
  </div>
</div>
