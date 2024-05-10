<?php
require 'sessionhandler.php';

if (session_handler_check_login()) {

  require 'db.php';
  try {
    $cache = get_server_cache($conn, 'weather');
    if ($cache && time() - strtotime($cache['timestamp']) < 300) {
      error_log("TIME(): " . time());
      error_log("STRTOTIME(): " . strtotime($cache['timestamp']));
      error_log("TIME DIFFERENCE: " . (time() - strtotime($cache['timestamp'])));
      error_log("WEATHER SERVER: Using cached weather data");
      echo $cache['data'];
      exit();
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
        throw new Exception("Error fetching weather data");
      } else {
        $decoded = json_decode($response, TRUE);
        error_log("WEATHER SERVER: Making request to weather API - Status: " . $decoded['cod']);
        set_server_cache($conn, 'weather', $response);
        echo $response;
      }
    }
  } catch (Exception $e) {
    error_log("WEATHER SERVER: " . $e->getMessage());
    echo json_encode($e->getMessage());
  } finally {
    $conn->close();
  }
} else {
  echo json_encode("You are not logged in");
}