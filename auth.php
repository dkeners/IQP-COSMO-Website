<?php
//https://codeshack.io/secure-login-system-php-mysql/
//https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php
session_start();

require_once ('config.php');

if (!isset($_POST['username'], $_POST['password'])) {
  die('Please fill out the username and password fields!');
}

if ($stmt = $con->prepare('SELECT id, password FROM authusers WHERE username = ?')) {
  $stmt->bind_param('s', $_POST['username']);
  $stmt->execute();

  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $password);
    $stmt->fetch();

    if (password_verify($_POST['password'], $password)) {
      session_regenerate_id();
      $_SESSION['logged_in'] = TRUE;
      $_SESSION['name'] = $_POST['username'];
      $_SESSION['id'] = $id;
      header('Location: manageData.php');
      die;
    } else {
      echo 'Incorrect username and/or password.';
    }
  } else {
    echo 'Incorrect username and/or password.';
  }

  $stmt->close();

  die;
}
?>
