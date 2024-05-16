<?php
if (session_handler_check_login()) {
  ?>
  <div class="full-page">
    <a href="index.php" class="reset-link big-clock-container button"
      onclick="event.preventDefault(); window.location.href=this.href;">
      <div class="image-container div-style"></div>
    </a>
  </div>
  <?php
  $dir = './assets/pictures/';
  $files = array_diff(scandir($dir), array('..', '.'));
  $images = array_filter($files, function ($file) {
    return in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']);
  });
  ?>
  <script>
    var images = <?php echo json_encode(array_values($images)); ?>;
    function changeImage() {
      var imageContainer = document.querySelector('.image-container');
      var randomIndex = Math.floor(Math.random() * images.length);
      imageContainer.style.backgroundImage = 'url("../assets/pictures/' + images[randomIndex] + '")';
    }
    changeImage();
    setInterval(changeImage, 5 * 60* 1000);
  </script>
  <?php
}
?>