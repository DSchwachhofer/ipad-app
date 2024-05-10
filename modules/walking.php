<?php
if (session_handler_check_login()) {
  ?>
  <p class="bottom-text" id="walking"></p>
  <script src="scripts/walking.js"></script>
  <?php
}
?>