<?php

// Connection info
define('DB_SERVER', "localhost");
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'cosmodb');

$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (mysqli_connect_errno()) {
  die("Error: Could not connect to the database.   " . mysqli_connect_error());
}

?>
