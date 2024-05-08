<?php
if ($_SESSION['isloggedin']) {
  ?>

  <div id="main_page">
    <div class="full-page">
      <!-- left big container -->
      <div class="outer-big-container">
        <?php include 'modules/pomodoro.php'; ?>
        <!-- right big container -->
        <div class="big-container div-style"></div>
      </div>
      <div class="outer-big-container">
        <!-- left small containers -->
        <div class="outer-small-container">
          <a class="reset-link inner-smallest-container div-style button" href="index.php?page=clock">
            <?php include 'modules/smallclock.php'; ?>
          </a>
          <div class="inner-smallest-container div-style"></div>
        </div>
        <!-- right small containers -->
        <div class="outer-small-container">
          <div class="inner-smallest-container div-style"></div>
          <div class="inner-smallest-container div-style"></div>
        </div>
      </div>
    </div>

    <?php
}
?>