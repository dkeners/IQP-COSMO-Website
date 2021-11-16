<?php

session_start();

if (!isset($_SESSION['logged_in'])) {

  header('Location: login.php');
  die;

} elseif (isset($_POST['Delete'])) {

  require_once('config.php');

  if ($_POST['Delete'] == 'location') {
    // if we are deleting a location, find the location and delete it.
    if ($stmt = $con->prepare('DELETE FROM locationdata WHERE (id = ?);')) {
      $stmt->bind_param('s', $_POST['locationID']);

      $stmt->execute();

      $stmt->close();

      header('Location: addData.php?dataSubmitted=1');
      die;
    } else {
      header('Location: addData.php?dataSubmitted=0');
      die;
    }
  } elseif ($_POST['Delete'] == 'event') {
    // WE DONT CARE ABOUT EVENTS YET SO NOT INCLUDED
    header('Location: addData.php?dataSubmitted=0');
    die;
  } else {
    // IF DELETE WAS TRUE, BUT NO VALID TABLE, QUIT
    header('Location: addData.php?dataSubmitted=0');
    die;
  }

} elseif (isset($_POST['Update'])) {

  require_once('config.php');

  if ($stmt = $con->prepare('INSERT INTO locationdata (Name_IT, Name_EN, Description_IT, Description_EN, Organization_IT, Organization_EN, Address, Longitude, Latitude, Type, Exhibit, Performance, Theatre, Opera, Museum, Civici, Gallery, Non_Profit, Public, Education, Venue_Size, Visit_Capacity, Acoustics, Venue_Rent)
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);')) {

    // Setting defaults
    $Name_IT = (isset($_POST['Name_IT'])) ? $_POST['Name_IT'] : '' ;
    $Name_EN = (isset($_POST['Name_EN'])) ? $_POST['Name_EN'] : '' ;
    $Description_IT = (isset($_POST['Description_IT'])) ? $_POST['Description_IT'] : '' ;
    $Description_EN = (isset($_POST['Description_EN'])) ? $_POST['Description_EN'] : '' ;
    $Organization_IT = (isset($_POST['Organization_IT'])) ? $_POST['Organization_IT'] : '' ;
    $Organization_EN = (isset($_POST['Organization_EN'])) ? $_POST['Organization_EN'] : '' ;
    $Address = (isset($_POST['Address'])) ? $_POST['Address'] : 'Venice' ;
    $Longitude = (isset($_POST['Longitude'])) ? $_POST['Longitude'] : '' ;
    $Latitude = (isset($_POST['Latitude'])) ? $_POST['Latitude'] : '' ;
    $Type = (isset($_POST['Type'])) ? $_POST['Type'] : 'Other' ;
    $Exhibit = (isset($_POST['specialty1'])) ? '1' : '0' ;
    $Performance = (isset($_POST['specialty2'])) ? '1' : '0' ;
    $Theatre = (isset($_POST['specialty3'])) ? '1' : '0' ;
    $Opera = (isset($_POST['specialty4'])) ? '1' : '0' ;
    $Museum = (isset($_POST['specialty5'])) ? '1' : '0' ;
    $Civici = (isset($_POST['specialty6'])) ? '1' : '0' ;
    $Gallery = (isset($_POST['specialty7'])) ? '1' : '0' ;
    $Non_Profit = (isset($_POST['Non_Profit'])) ? '1' : '0' ;
    $Public = (isset($_POST['Public'])) ? '1' : '0' ;
    $Education = (isset($_POST['Education'])) ? '1' : '0' ;
    $Venue_Size = (isset($_POST['Venue_Size'])) ? $_POST['Venue_Size'] : '' ;
    $Visit_Capacity = (isset($_POST['Visit_Capacity'])) ? $_POST['Visit_Capacity'] : '' ;
    $Acoustics = (isset($_POST['Acoustics'])) ? $_POST['Acoustics'] : '' ;
    $Venue_Rent = (isset($_POST['Venue_Rent'])) ? $_POST['Venue_Rent'] : '' ;


    $stmt->bind_param('ssssssssssssssssssssssss', $Name_IT, $Name_EN, $Description_IT,
                                                 $Description_EN, $Organization_IT,
                                                 $Organization_EN, $Address, $Longitude,
                                                 $Latitude, $Type, $Exhibit,
                                                 $Performance, $Theatre, $Opera,
                                                 $Museum, $Civici, $Gallery,
                                                 $Non_Profit, $Public, $Education,
                                                 $Venue_Size, $Visit_Capacity,
                                                 $Acoustics, $Venue_Rent);

    $stmt->execute();

    $stmt->close();

    header('Location: addData.php?dataSubmitted=1');
    die;

  } else {

    header('Location: addData.php?dataSubmitted=0');
    die;

  }

} elseif (isset($_GET['dataSubmitted'])) {

  $lastPostSuccess = ($_GET['dataSubmitted'] == 1) ? "Post was a success: 201" : "Post failed";

} else {

  $lastPostSuccess = "";

}

// Setting the page and language type
$page = "addData";

// Set the engine to catch no errors
set_error_handler(function() { /* ignore errors */ });

// determine the language of the page to display, default english
if ($_GET['lang'] == "it" || $_POST['lang'] == "it") {
  $lang = "it";
} else {
  $lang = "en";
}

// Everything should be caught after here
restore_error_handler();

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Data Management</title>
    <link rel="stylesheet" href="css/master.css">
  </head>
  <body>

    <?php include_once 'shared/header.php'; ?>

    <div class="main-content">
      <h1><?php echo $lastPostSuccess ?></h1>
      <form class="box" action="addData.php" method="post" id="locationForm">
        <h1>Create Location Data Entry</h1>
        <div class="form-holder">
          <input type="hidden" name="Update" value="location">
          <h4>Names: (both languages)</h4>
          <input type="text" name="Name_IT" placeholder="Italian Name" id="Name_IT" required>
          <input type="text" name="Name_EN" placeholder="English Name" id="Name_EN" required>
          <br><br>
          <h4>Description: (both languages)</h4>
          <input type="text" name="Description_IT" placeholder="Italian Description" id="Description_IT" required>
          <input type="text" name="Description_EN" placeholder="English Description" id="Description_EN" required>
          <br><br>
          <h4>Organization: (both languages)</h4>
          <input type="text" name="Organization_IT" placeholder="Italian Organization" id="Organization_IT" required>
          <input type="text" name="Organization_EN" placeholder="English Organization" id="Organization_EN" required>
          <br><br>
          <h4>Location Data</h4>
          <input type="text" name="Address" placeholder="Area, Number" id="Address" required>
          <br>
          <input type="text" name="Longitude" placeholder="Longitude: ~45.4" id="Longitude" required>
          <input type="text" name="Latitude" placeholder="Latitude: ~12.3" id="Latitude" required>
          <br><br>
          <h4>Type</h4>
          <input type="radio" id="Type" name="Type" value="Theatre">Theatre</input>
          <input type="radio" id="Type" name="Type" value="Opera">Opera</input>
          <input type="radio" id="Type" name="Type" value="Museum">Museum</input>
          <input type="radio" id="Type" name="Type" value="Gallery">Gallery</input>
          <br><br>
          <h4>Specialty</h4>
          <input type="checkbox" id="specialty1" name="specialty1" value="Exhibit">
          <label for="specialty1">Exhibit</label><br>
          <input type="checkbox" id="specialty2" name="specialty2" value="Performance">
          <label for="specialty2">Performance</label><br>
          <input type="checkbox" id="specialty3" name="specialty3" value="Theatre">
          <label for="specialty3">Theatre</label><br>
          <input type="checkbox" id="specialty4" name="specialty4" value="Opera">
          <label for="specialty4">Opera</label><br>
          <input type="checkbox" id="specialty5" name="specialty5" value="Museum">
          <label for="specialty5">Museum</label>
          <input type="checkbox" id="specialty6" name="specialty6" value="Civici">
          <label for="specialty6">Civici</label><br>
          <input type="checkbox" id="specialty7" name="specialty7" value="Gallery">
          <label for="specialty7">Gallery</label>
          <br><br>
          <h4>Non or For-Profit</h4>
          <input type="radio" id="Non-Profit" name="Profit" value="Non-Profit">Non-Profit</input>
          <input type="radio" id="For Profit" name="Profit" value="For Profit">For Profit</input>
          <br><br>
          <h4>Public Space?</h4>
          <input type="radio" id="Public Space" name="Public" value="Public Space">Public Space</input>
          <input type="radio" id="Private Space" name="Public" value="Private Space">Private Space</input>
          <br><br>
          <h4>Educational Programs Offered?</h4>
          <input type="radio" id="EducationY" name="Education" value="Yes">Yes</input>
          <input type="radio" id="EducationN" name="Education" value="No">No</input>
          <br><br>
          <h4>Venue Size</h4>
          <input type="radio" id="Venue_Size" name="Venue_Size" value="Small">Small</input>
          <input type="radio" id="Venue_Size" name="Venue_Size" value="Medium">Medium</input>
          <input type="radio" id="Venue_Size" name="Venue_Size" value="Big">Big</input>
          <br><br>
          <h4>Visitor Capacity</h4>
          <input type="radio" id="Visit_Capacity" name="Visit_Capacity" value="1-10">1-10</input>
          <input type="radio" id="Visit_Capacity" name="Visit_Capacity" value="11-20">11-20</input>
          <input type="radio" id="Visit_Capacity" name="Visit_Capacity" value="21-30">21-30</input>
          <input type="radio" id="Visit_Capacity" name="Visit_Capacity" value="31-50">31-50</input>
          <input type="radio" id="Visit_Capacity" name="Visit_Capacity" value="51-100">51-100</input>
          <input type="radio" id="Visit_Capacity" name="Visit_Capacity" value="101-200">101-200</input>
          <input type="radio" id="Visit_Capacity" name="Visit_Capacity" value="200+">200+</input>
          <br><br>
          <h4>Acoustics</h4>
          <input type="radio" id="Accoustics" name="Accoustics" value="music">For musical performance</input>
          <input type="radio" id="Accoustics" name="Accoustics" value="theatre">For theatrical performance</input>
          <input type="radio" id="Accoustics" name="Accoustics" value="speaking">For speaking/conversation</input>
          <input type="radio" id="Accoustics" name="Accoustics" value="none">No audio (silent)</input>
          <br><br>
          <h4>Production</h4>
          <input type="checkbox" id="Production" name="Production" value="Host">Host</input>
          <input type="checkbox" id="Production" name="Production" value="Co-Produce">Co-Produce</input>
          <input type="checkbox" id="Production" name="Production" value="Produce">Produce</input>
          <br><br>
        </div>
        <br><br>
        <input type="submit" value="Submit">
      </form>

      <!-- FORM FOR CREATING EVENTS
      <form class="box" action="auth.php" method="post" id="locationForm">
        <h1>Create Event Data Entry</h1>
        <div class="form-holder">
          <p>Names: (both languages)</p>
          <input type="text" name="Name_IT" placeholder="Italian Name" id="Name_IT" required>
          <input type="text" name="Name_EN" placeholder="English Name" id="Name_EN" required>
          <br><br>
          <p>Names: (both languages)</p>
          <input type="text" name="username" placeholder="Username" id="username" required>
          <input type="text" name="password" placeholder="Password" id="password" required>
          <input type="text" name="username" placeholder="Username" id="username" required>
          <input type="text" name="password" placeholder="Password" id="password" required>
        </div>
        <br><br>
        <input type="submit" value="Submit">
      </form> -->
    </div>
  </body>
</html>
