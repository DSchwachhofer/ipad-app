<?php
if ($_SESSION['isloggedin']) {
  ?>

  <div class="full-page">
    <a href="index.php" class="reset-link big-clock-container button div-style">
      <p class="big-clock" id="date-time"></p>
    </a>
  </div>

  <script src="../scripts/utilities.js"></script>
  <script src="../scripts/clock.js"></script>

  <?php
}
?>