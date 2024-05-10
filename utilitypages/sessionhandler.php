<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['isloggedin'])) {
  $_SESSION['isloggedin'] = false;
}

function session_handler_login()
{
  $_SESSION['isloggedin'] = true;
  session_regenerate_id(true);
}

function session_handler_logout()
{
  $_SESSION['isloggedin'] = false;
}

function session_handler_check_login()
{
  return isset($_SESSION['isloggedin']) && $_SESSION['isloggedin'] === true;
}

function session_handler_set_weather_cache($data)
{
  $_SESSION['weather_cache'] = [
    'timestamp' => time(),
    'data' => $data
  ];
}

function session_handler_get_weather_data()
{
  return $_SESSION['weather_cache']['data'];
}

function session_handler_should_load_weather()
{
  return isset($_SESSION['weather_cache']) && $_SESSION['weather_cache']['timestamp'] > time() - 300;
}