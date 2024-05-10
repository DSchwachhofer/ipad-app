<?php
require 'sessionhandler.php';

if (session_handler_check_login()) {
  require 'db.php';
  $method = $_SERVER['REQUEST_METHOD'];
  error_log("HABITS SERVER: method is " . $method);
  if ($method === 'GET') {
    $habit_get_data = get_data($conn);
    if ($habit_get_data === null) {
      return_error('Error fetching data');
    } else {
      error_log("HABITS SERVER: data is complete");
      echo json_encode($habit_get_data);
    }
  } elseif ($method === 'POST') {
    try {
      $input = json_decode(file_get_contents('php://input'), true);
      if ($input === null) {
        throw new Exception('Invalid JSON input');
      }
      $feedback = edit_habit($conn, $input);
      echo json_encode($feedback);
    } catch (Exception $e) {
      return_error('Error processing request: ' . $e->getMessage());
    }
  } else {
    return_error('Unsupported method');
  }
  $conn->close();
} else {
  return_error('You are not logged in.');
}

function get_data($conn)
{
  try {
  $data = db_get_habits($conn);

  foreach ($data as &$row) {
    $row['percentage'] = calculate_percentage($row);
  }
  return $data;
  } catch (Exception $e) {
    return null;
  }
}

function edit_habit($conn, $input)
{
  error_log("HABITS SERVER: editing habit");
  switch ($input['action']) {
    case 'create':
      $feedback = db_create_habit($conn, $input);
      break;
    case 'edit':
      // edit_habit($conn, $input);
      break;
    case 'delete':
      // delete_habit($conn, $input);
      break;
    case 'complete':
      // complete_habit($conn, $input);
      break;
    default:
      $feedback = array('status' => 'error', 'message' => 'Unsupported action');
  }

  return $feedback;
}

function return_error($message)
{
  echo json_encode(array('status' => 'error', 'message' => $message));
}

function calculate_percentage($habit)
{
  $current_time = time();
  $start_time = strtotime($habit['starttime']);
  $duration = get_habit_duration($habit);
  $percentage = ($current_time - $start_time) / $duration;
  return $percentage;
}

function get_habit_duration($habit)
{
  $day_in_seconds = 60 * 60 * 24;
  $duration_of_one_repetition = 0;
  switch ($habit['repetition']) {
    case 'Day':
      $duration_of_one_repetition = $day_in_seconds;
      break;
    case 'Week':
      $duration_of_one_repetition = $day_in_seconds * 7;
      break;
    case 'Month':
      $duration_of_one_repetition = $day_in_seconds * 30;
      break;
    case 'Year':
      $duration_of_one_repetition = $day_in_seconds * 365;
      break;
    default:
      $duration_of_one_repetition = $day_in_seconds;
  }
  $duration_in_seconds = $duration_of_one_repetition / $habit['repetition'];
  return $duration_in_seconds;
}