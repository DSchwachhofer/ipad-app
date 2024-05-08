<?php
if ($_SESSION['isloggedin']) {
  ?>
  <p class="bottom-text" id="weather-text"></p>
  <img id="weather-icon">

  <script src="../scripts/weather.js"></script>
  <?php
}
?>