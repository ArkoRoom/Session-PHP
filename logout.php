<?php
  require 'config.php';
  unset($_SESSION['id'], $_SESSION['login']);
  unset($_COOKIE['id'], $_COOKIE['login']);
  setcookie('remember', null, time() - 1);
  //replace logout.php
  $url = str_replace('logout.php', '', $url);
  header("Location: ".$url);
?>
