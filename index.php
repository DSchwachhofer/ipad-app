<?php
// turn on error reporting for development code
ini_set('display_errors', '1');
error_reporting(E_ALL);
// turn off error reporting for production code
// ini_set('display_errors', '0');
// error_reporting(0);
include './utilitypages/sessionhandler.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="./assets/favicon.ico" type="image/x-icon">
  <title>Time Machine</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <?php
  $allowed_pages = ['main', 'clock', 'login'];
  $page = $_GET['page'] ?? 'main';
  if (!session_handler_check_login()) {
    include 'mainpages/login.php';
  } elseif (preg_match('/^[a-z0-9\-]+$/i', $page) && file_exists("mainpages/{$page}.php") && in_array($page, $allowed_pages)) {
    include "mainpages/{$page}.php";
  } else {
    include 'mainpages/main.php';
  }
  ?>

  <?php if (session_handler_check_login()) {
    if ($page === 'main') {
      echo '<script src="scripts/utilities.js"></script>';
      echo '<script src="../scripts/timer.js"></script>';
      echo '<script src="scripts/weather.js"></script>';
    } elseif ($page === 'clock') {
      echo '<script src="scripts/utilities.js"></script>';
      echo '<script src="../scripts/clock.js"></script>';
      echo '<script src="scripts/weather.js"></script>';
    }
  }
  ?>
</body>

</html>