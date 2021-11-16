<?php

session_start();

if (isset($_SESSION['logged_in'])) {
  header('Location: addData.php');
  die;
}

// Setting the page and language type
$page = "login";

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
    <title>OAV Account Login</title>
    <link rel="stylesheet" href="css/master.css">
    <style media="screen">
      .flex-center {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        min-height: 100%;
        min-width: 100%;
      }
      .form-holder {
        margin: 20px 0px;
      }
    </style>
  </head>

  <body>

    <?php include_once 'shared/header.php'; ?>

    <div class="main-content">
      <div class="flex-center">
        <h1>Login Page</h1>
        <form class="flex-center" action="auth.php" method="post" id="loginForm">
          <div class="form-holder">
            <input type="text" name="username" placeholder="Username" id="username" required>
            <input type="password" name="password" placeholder="Password" id="password" required>
          </div>
          <input type="submit" value="Login">
        </form>
      </div>
    </div>

    <?php include_once 'shared/footer.php'; ?>

</html>
