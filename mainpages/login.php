<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include './utilitypages/db.php';
  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
  $password = $_POST['password'];

  // Retrieve the hashed password from the database

  $sql = "SELECT password FROM userdata WHERE username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $username);
  $stmt->execute();

  $stmt->bind_result($hashed_password);
  $stmt->fetch();

  $user = new stdClass();
  $user->password = $hashed_password;


  // Verify the password
  if ($user && password_verify($password, $user->password)) {
    // The password is correct
    $_SESSION['isloggedin'] = true;
    session_regenerate_id(true);
    header('Location: index.php');
    exit;

  } else {
    // The password is incorrect
    $_SESSION['isloggedin'] = false;
    header('Location: index.php?page=login');
  }

  $conn->close();
}
?>

<div class="full-page">
  <div class="big-clock-container div-style">
    <div>
      <form action="index.php?page=login" method="post">
        <div class="login-input-div">
          <label for="username" class="login-label">Username</label>
          <input type="text" class="login-input" id="username" name="username" required>
        </div>
        <div class="login-input-div">
          <label for="password" class="login-label">Password</label>
          <input type="password" class="login-input" id="password" name="password" required>
        </div>
        <button type="submit" class="login-button button">Log In</button>
      </form>
    </div>
  </div>
</div>