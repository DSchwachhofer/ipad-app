<?php
// COMMENT OUT THE FOLLOWING LINES IN PRODUCTION CODE
require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$servername = isset($_ENV['DB_HOST']) ? $_ENV['DB_HOST'] : getenv('DB_HOST');
$username = isset($_ENV['DB_USER']) ? $_ENV['DB_USER'] : getenv('DB_USER');
$password = isset($_ENV['DB_PASS']) ? $_ENV['DB_PASS'] : getenv('DB_PASS');
$dbname = isset($_ENV['DB_NAME']) ? $_ENV['DB_NAME'] : getenv('DB_NAME');
$port = isset($_ENV['DB_PORT']) ? $_ENV['DB_PORT'] : getenv('DB_PORT');

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

function get_server_cache($conn, $name)
{
  error_log("DB: GETTING SERVER CACHE: $name");
  $sql = "SELECT name, data, timestamp FROM server_cache WHERE name = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $name);
  $stmt->execute();

  $stmt->bind_result($name, $data, $timestamp);

  if ($stmt->fetch()) {
    return ['name' => $name, 'data' => $data, 'timestamp' => $timestamp];
  } else {
    error_log("NULL CACHE: $name");
    return null;
  }
}

function set_server_cache($conn, $name, $data)
{
  error_log("DB: SETTING SERVER CACHE: $name");
  $sql = "INSERT INTO server_cache (name, data, timestamp) VALUES (?, ?, UTC_TIMESTAMP()) ON DUPLICATE KEY UPDATE data = VALUES(data), timestamp = UTC_TIMESTAMP()";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $name, $data);

  $stmt->execute();
}

function get_walking_data($conn)
{
  error_log("DB: GETTING WALKING DATA");
  $sql = "SELECT ROUND(SUM(distance), 2) as total_distance FROM walk_log";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    return $row['total_distance'];
  } else {
    return null;
  }
}

function db_get_habits($conn)
{
  error_log("DB: GETTING HABITS DATA");
  $sql = "SELECT * FROM habits";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $habits = [];
    while ($row = $result->fetch_assoc()) {
      $habits[] = $row;
    }
    return $habits;
  } else {
    return null;
  }
}

function db_create_habit($conn, $input)
{
  try {
    error_log("DB: create HABIT");
    $sql = "INSERT INTO habits (habit, color, repetition, duration, starttime) VALUES (?, ?, ?, ?, UTC_TIMESTAMP())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssis", $input['habit'], $input['color'], $input['repetition'], $input['duration']);
    $stmt->execute();
    return array('status' => 'success', 'message' => 'Habit created successfully');

  } catch (Exception $e) {
    return array('status' => 'error', 'message' => 'Could not create habit: ' . $e->getMessage());
  }
}

function db_edit_habit($conn, $input)
{
  try {
    error_log("DB: edit HABIT");
    $sql = "UPDATE habits SET habit = ?, color = ?, repetition = ?, duration = ?, starttime = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssissi", $input['habit'], $input['color'], $input['repetition'], $input['duration'], $input['starttime'], $input['id']);
    if ($stmt->execute()) {
      return array('status' => 'success', 'message' => 'Habit edited successfully');
    } else {
      error_log("DB: execute error: " . $stmt->error);
      return array('status' => 'error', 'message' => 'Could not edit habit: ' . $stmt->error);
    }
  } catch (Exception $e) {
    return array('status' => 'error', 'message' => 'Could not create habit: ' . $e->getMessage());
  }
}

function db_delete_habit($conn, $input)
{
  try {
    error_log("DB: delete HABIT");
    $sql = "DELETE FROM habits WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $input['id']);
    if ($stmt->execute()) {
      return array('status' => 'success', 'message' => 'Habit deleted successfully');
    } else {
      return array('status' => 'error', 'message' => 'Could not delete habit: ' . $stmt->error);
    }
  } catch (Exception $e) {
    return array('status' => 'error', 'message' => 'Could not delete habit: ' . $e->getMessage());
  }
}