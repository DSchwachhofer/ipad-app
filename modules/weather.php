<?php
if (session_handler_check_login()) {
  ?>
  <p class="bottom-text" id="weather-text"></p>
  <img id="weather-icon">
  <script src="../scripts/weather.js"></script>
  <?php
}
?>