<?php
  include './sessionhandler.php';
  session_handler_logout();
  header('Location: ../index.php');
  exit();