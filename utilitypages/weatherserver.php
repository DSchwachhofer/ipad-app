<?php
session_start();
// COMMENT OUT THE FOLLOWING LINES IN PRODUCTION CODE
require '../vendor/autoload.php';

if ($_SESSION['isloggedin']) {

  if (isset($_SESSION['weather_cache']) && $_SESSION['weather_cache']['timestamp'] > time() - 300) {
    echo $_SESSION['weather_cache']['data'];

  } else {

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();

    $weatherapikey = isset($_ENV['WEATHER_API_KEY']) ? $_ENV['WEATHER_API_KEY'] : getenv('WEATHER_API_KEY');
    $weatherlatitude = isset($_ENV['WEATHER_LATITUDE']) ? $_ENV['WEATHER_LATITUDE'] : getenv('WEATHER_LATITUDE');
    $weatherlongitude = isset($_ENV['WEATHER_LONGITUDE']) ? $_ENV['WEATHER_LONGITUDE'] : getenv('WEATHER_LONGITUDE');
    $endpoint = "https://api.openweathermap.org/data/2.5/weather";

    $url = $endpoint . "?lat=$weatherlatitude&lon=$weatherlongitude&units=metric&appid=$weatherapikey";
    $response = file_get_contents($url);
    if ($response === FALSE) {
      echo json_encode("Error fetching weather data");
      exit();
    } else {

      $_SESSION['weather_cache'] = [
        'timestamp' => time(),
        'data' => $response
      ];

      echo $response;
    }
  }
} else {
  echo json_encode("You are not logged in");
}