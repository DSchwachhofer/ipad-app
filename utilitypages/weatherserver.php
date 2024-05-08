<?php
session_start();

if ($_SESSION['isloggedin']) {

  if (isset($_SESSION['weather_cache']) && $_SESSION['weather_cache']['timestamp'] > time() - 300) {
    error_log("WEATHER SERVER: Sending cached weather data");
    echo $_SESSION['weather_cache']['data'];
  } else {

    // COMMENT OUT THE FOLLOWING LINES IN PRODUCTION CODE
    require '../vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();

    $weatherapikey = isset($_ENV['WEATHER_API_KEY']) ? $_ENV['WEATHER_API_KEY'] : getenv('WEATHER_API_KEY');
    $weatherlatitude = isset($_ENV['WEATHER_LATITUDE']) ? $_ENV['WEATHER_LATITUDE'] : getenv('WEATHER_LATITUDE');
    $weatherlongitude = isset($_ENV['WEATHER_LONGITUDE']) ? $_ENV['WEATHER_LONGITUDE'] : getenv('WEATHER_LONGITUDE');
    $endpoint = "https://api.openweathermap.org/data/2.5/weather";

    $url = $endpoint . "?lat=$weatherlatitude&lon=$weatherlongitude&units=metric&appid=$weatherapikey";
    $response = file_get_contents($url);
    if ($response === FALSE) {
      error_log("WEATHER SERVER: Error fetching weather data");
      echo json_encode("Error fetching weather data");
      exit();
    } else {
      $decoded = json_decode($response, TRUE);
      error_log("WEATHER SERVER: Making request to weather API - Status: " . $decoded['cod']);
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