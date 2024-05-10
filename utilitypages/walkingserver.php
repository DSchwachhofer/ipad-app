<?php
require 'sessionhandler.php';

if (session_handler_check_login()) {
  require 'db.php';
  try {
  $distance = get_walking_data($conn);
  if ($distance === null) {
    throw new Exception("No walking data found");
  }
  echo json_encode($distance);
  } catch (Exception $e) {
    error_log("WALKING SERVER: " . $e->getMessage());
    echo json_encode($e->getMessage());
  } finally {
    $conn->close();
  }
} else {
  echo json_encode("Your are not logged in");
}