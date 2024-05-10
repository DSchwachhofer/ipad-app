<?php
if (session_handler_check_login()) {
  ?>
  <p class="bottom-text" id="power-text"></p>
  <script src="scripts/solar.js"></script>
  <?php
}
?>