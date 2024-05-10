<?php
require 'sessionhandler.php';

if (session_handler_check_login()) {

  require '../vendor/autoload.php';
  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
  $dotenv->load();

  $solarapikey = isset($_ENV['SOLAR_API_KEY']) ? $_ENV['SOLAR_API_KEY'] : getenv('SOLAR_API_KEY');
  $siteid = isset($_ENV['SOLAR_SITE_ID']) ? $_ENV['SOLAR_SITE_ID'] : getenv('SOLAR_SITE_ID');
  
  error_log("SOLAR SERVER: HELLO");
  echo json_encode("SOLAR SERVER SAYS HELLO!");
} else {
  echo json_encode("You are not logged in");
}