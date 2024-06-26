<?php
if (session_handler_check_login()) {
  ?>

  <div id="main_page">
    <div class="full-page">
      <!-- left big container -->
      <div class="outer-big-container">
        <?php include 'modules/pomodoro.php'; ?>
        <!-- right big container -->
        <div class="big-container div-style">
          <?php include 'modules/habits.php'; ?>
        </div>
      </div>
      <div class="outer-big-container">
        <!-- left small containers -->
        <div class="outer-small-container">
          <a class="reset-link inner-smallest-container div-style button" href="index.php?page=clock"
            onclick="event.preventDefault(); window.location.href=this.href;">
            <?php include 'modules/smallclock.php'; ?>
          </a>
          <div class="inner-smallest-container div-style">
            <?php include 'modules/weather.php'; ?>
          </div>
        </div>
        <!-- right small containers -->
        <div class="outer-small-container">
          <div class="inner-smallest-container div-style">
            <?php include 'modules/solar.php'; ?>
          </div>
          <div class="inner-smallest-container div-style">
            <?php include 'modules/walking.php'; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="outer-big-container">
      <a class="reset-link footer div-style button" href="utilitypages/logout.php"
        onclick="event.preventDefault(); window.location.href=this.href;">
        <p class="bottom-text">log out</p>
      </a>
    </div>
  </div>

  <?php
}
?>