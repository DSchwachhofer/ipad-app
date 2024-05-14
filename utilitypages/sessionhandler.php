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
  session_unset();
  session_destroy();
}

function session_handler_check_login()
{
  return isset($_SESSION['isloggedin']) && $_SESSION['isloggedin'] === true;
}