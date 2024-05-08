<?php
// turn on error reporting for development code
ini_set('display_errors', '1');
error_reporting(E_ALL);
// turn off error reporting for production code
// ini_set('display_errors', '0');
// error_reporting(0);
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION['isloggedin'])) {
  $_SESSION['isloggedin'] = false;
}
// $_SESSION['isloggedin'] = false;
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
  if (!$_SESSION['isloggedin']) {
    include 'mainpages/login.php';
  } elseif (preg_match('/^[a-z0-9\-]+$/i', $page) && file_exists("mainpages/{$page}.php") && in_array($page, $allowed_pages)) {
    include "mainpages/{$page}.php";
  } else {
    include 'mainpages/main.php';
  }
  ?>
</body>

</html>