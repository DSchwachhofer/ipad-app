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
  $sql = "SELECT * FROM server_cache WHERE name = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $name);
  $stmt->execute();

  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    return $row;
  } else {
    error_log("NULL CACHE: $name");
    return null;
  }
}

function set_server_cache($conn, $name, $data)
{
  error_log("DB: SETTING SERVER CACHE: $name");
  $sql = "INSERT INTO server_cache (name, data, timestamp) VALUES (?, ?, NOW()) ON DUPLICATE KEY UPDATE data = VALUES(data), timestamp = NOW()";

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