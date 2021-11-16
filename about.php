<?php

session_start();

// Check to see if logged in, if so add a logout button.
// If not logged in add a login button.
if (isset($_SESSION['logged_in'])) {
  $login_out_button = "
    <form class='' action='addData.php' method='get'>
      <input type='submit' name='' value='To Data Management'>
    </form>
    <form class='' action='logout.php' method='post'>
        <input type='submit' name='' value='Logout'>
    </form>";
} else {
  $login_out_button = "
    <form class='' action='login.php' method='get'>
        <input type='submit' name='' value='Login'>
    </form>";
}

// Setting the page and language type
$page = "about";

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
    <title>About</title>
    <link rel="stylesheet" href="css/master.css">
  </head>

  <body>

    <?php include_once 'shared/header.php'; ?>

    <div class="main-content">
      <h1>About</h1>
      <p>here is a paragraph about what we do etc...</p>
      <?php echo $login_out_button; ?>
    </div>

    <?php include_once 'shared/footer.php'; ?>

</html>
