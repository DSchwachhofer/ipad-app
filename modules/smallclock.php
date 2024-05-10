<?php
if (session_handler_check_login()) {
  ?>

  <p class="bottom-text" id="date-time"></p>

  <script src="../scripts/utilities.js"></script>
  <script src="../scripts/clock.js"></script>

  <?php
}
?>