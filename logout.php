<?php
  require 'config.php';
  unset($_SESSION['id'], $_SESSION['login']);
  //replace logout.php
  $url = str_replace('logout.php', '', $url);
  header("Location: ".$url);
?>
