<?php
if (session_handler_check_login()) {
  ?>

  <div class="full-page">
    <a href="index.php" class="reset-link big-clock-container button div-style">
      <p class="big-clock" id="date-time"></p>
      <div id="big-weather-div">
          <p id="weather-text"></p>
          <img id="weather-icon">
        </div>
    </a>
  </div>
  <?php
}
?>