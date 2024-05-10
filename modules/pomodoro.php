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
}
?>