<?php
if (session_handler_check_login()) {
  $allowed_image_pages = ['family', 'other', 'none'];
  $image_page = $_GET['images'] ?? 'none';
  $allowed_clock_pages = ['small', 'none'];
  $clock_page = $_GET['clock'] ?? 'none';
  ?>

  <div class="full-page">
    <?php if ($image_page === 'none') { ?>
      <a href="index.php" class="reset-link big-clock-container button div-style"
        onclick="event.preventDefault(); window.location.href=this.href;">
        <p class="big-clock" id="date-time"></p>
        <div id="big-weather-div">
          <p id="weather-text"></p>
          <img id="weather-icon">
        </div>
      </a>
      <script src="scripts/utilities.js"></script>
      <script src="scripts/clock.js"></script>
      <script src="scripts/weather.js"></script>
      <?php } else { ?>
      <a href="index.php" class="reset-link big-<?php echo $image_page === "family" ? "image" : "clock" ?>-container button"
        onclick="event.preventDefault(); window.location.href=this.href;">
        <div class="image-container <?php echo $image_page === "other" ? "div-style" : "" ?>">
          <?php if ($clock_page === 'small') { ?>
            <div class="picture-clock-container">
                <p class="picture-clock" id="date-time"></p>
                <div id="big-weather-div">
                  <p id="weather-text"></p>
                  <img id="weather-icon">
              </div>
            </div>
            <script src="scripts/utilities.js"></script>
            <script src="scripts/clock.js"></script>
            <script src="scripts/weather.js"></script>
          <?php } ?>
        </div>
      </a>
      <?php
      $dir = './assets/pictures/' . $image_page . '/';
      $files = array_diff(scandir($dir), array('..', '.'));
      $images = array_filter($files, function ($file) {
        return in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']);
      });
      ?>
      <script>
        var images = <?php echo json_encode(array_values($images)); ?>;
        var subfolder = '<?php echo $image_page; ?>';
        function changeImage() {
          var imageContainer = document.querySelector('.image-container');
          var randomIndex = Math.floor(Math.random() * images.length);
          imageContainer.style.backgroundImage = 'url("../assets/pictures/' + subfolder + '/' + images[randomIndex] + '")';
        }
        changeImage();
        setInterval(changeImage, 5 * 60 * 1000);
      </script>
      <?php
    } ?>
  </div>
  <div class="outer-big-container">
    <div class="outer-small-container margin-bottom-50">
      <a class="reset-link div-style button inner-smallest-container"
        href="index.php?page=clock&images=family&clock=<?php echo $clock_page; ?>"
        onclick="event.preventDefault(); window.location.href=this.href;">
        <p class="bottom-text">Family Pictures</p>
      </a>
      <a class="reset-link div-style button inner-smallest-container"
        href="index.php?page=clock&images=other&clock=<?php echo $clock_page; ?>"
        onclick="event.preventDefault(); window.location.href=this.href;">
        <p class="bottom-text">Other Pictures</p>
      </a>
    </div>
    <div class="outer-small-container margin-bottom-50">
      <a class="reset-link div-style button inner-smallest-container" href="index.php?page=clock"
        onclick="event.preventDefault(); window.location.href=this.href;">
        <p class="bottom-text">No Pictures</p>
      </a>
      <?php if ($image_page !== 'none') { ?>
        <a class="reset-link div-style button inner-smallest-container"
          href="index.php?page=clock&clock=<?php echo $clock_page === 'small' ? 'none' : 'small'; ?>&images=<?php echo $image_page; ?>"
          onclick="event.preventDefault(); window.location.href=this.href;">
          <p class="bottom-text"><?php echo $clock_page === "small" ? 'Hide Clock' : 'Show Clock' ?></p>
        </a>
      <?php } ?>
    </div>
  </div>

  <?php
}
?>