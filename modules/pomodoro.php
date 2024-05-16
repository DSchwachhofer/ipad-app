<?php
if (session_handler_check_login()) {
  ?>

  <div class="big-container pomodoro-container div-style">
    <div class="div-style circle">
      <div id="pomodoro-inner-circle"></div>
      <p id="pom-amount"> - </p>
      <p id="countdown"></p>
      <p id="should-work">start work</p>
    </div>
    <div class="timer-btn-container">
      <div class="timer-btn button" id="timer-start-btn">
        <p class="timer-btn-text">start</p>
      </div>
      <div class="timer-btn button" id="timer-cancel-btn">
        <p class="timer-btn-text">cancel</p>
      </div>
    </div>
  </div>
  <?php 
  require __DIR__ . '/../vendor/autoload.php';
  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
  $dotenv->load();

  $push_token = isset($_ENV['PUSH_TOKEN']) ? $_ENV['PUSH_TOKEN'] : getenv('PUSH_TOKEN');
  $push_user = isset($_ENV['PUSH_USER']) ? $_ENV['PUSH_USER'] : getenv('PUSH_USER');
  ?>
  <script>
    var pushToken = '<?php echo $push_token; ?>';
    var pushUser = '<?php echo $push_user; ?>';
  </script>
  <script src="scripts/utilities.js"></script>
  <script src="scripts/timer.js"></script>
  <?php
}
?>