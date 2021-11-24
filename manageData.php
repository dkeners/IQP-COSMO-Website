<?php

session_start();

if (!isset($_SESSION['logged_in'])) {

  header('Location: login.php');
  http_response_code(511);
  die;

}

// Check to see if a database query was made, if so display of it was succesfull
if (isset($_GET['dataSubmitted'])) {
  $lastPostSuccess = ($_GET['dataSubmitted'] == 1) ? "<h1>Post was a success: 201</h1>" : "<h1>Post failed</h1>";
} else {
  $lastPostSuccess = "";
}

// Setting the page and language type
$page = "manageData";

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
      <!-- Tells if the last server request was succesfull -->
      <?php echo $lastPostSuccess ?>
      <form class="box" action="adminFunc.php" method="post" id="locationForm">
        <h1>Create Location Data Entry</h1>
        <div class="form-holder">
          <input type="hidden" name="update" value="location">
          <!-- <?php
            (isset($_POST['id'])) ? "'" . $_POST['id'] . "'" : "" ;
          ?> -->
          <input type="hidden" name="id" value="<?php echo $id ?>">
          <!-- <h4>Names: (both languages)</h4> -->
          <h4>Names: (both languages)</h4>
          <input type="text" name="name_IT" placeholder="Italian Name" id="name_IT" required>
          <input type="text" name="name_EN" placeholder="English Name" id="name_EN">
          <br><br>
          <h4>Description: (both languages)</h4>
          <input type="text" name="description_IT" placeholder="Italian Description" id="description_IT">
          <input type="text" name="description_EN" placeholder="English Description" id="description_EN">
          <br><br>
          <h4>Organization: (both languages)</h4>
          <input type="text" name="organization_IT" placeholder="Italian Organization" id="organization_IT">
          <input type="text" name="organization_EN" placeholder="English Organization" id="organization_EN">
          <br><br>
          <h4>Location Data</h4>
          <input type="text" name="address" placeholder="Area, Number" id="address">
          <br>
          <input type="text" name="lat" placeholder="Latitude: ~45.4" id="lat" required>
          <input type="text" name="lon" placeholder="Longitude: ~12.3" id="lon" required>
          <br><br>
          <h4>Type</h4>
          <input type="text" name="type" placeholder="Show, Music, etc." id="type">
          <input type="text" name="evenice_type" placeholder="Arte e Cultura, Teatro, etc." id="evenice_type">
          <br><br>
          <h4>Website</h4>
          <input type="text" name="website" placeholder="example.com" id="website">
          <br><br>
        </div>
        <br><br>
        <input type="submit" value="Submit">
      </form>
      <!-- END LOCATION FORM <><><><><><><><><><><> START EVENT FORM -->

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
  <script type="text/javascript">

  </script>
</html>
