<?php
  require 'config.php';
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>PHP - Session</title>
    <link rel="stylesheet" href="css/style.css" media="screen" title="no title" charset="utf-8">
  </head>
  <body>
    <div id="background">
      <form method="POST">
        <div class="contentForm">
          <label for="login">Login* :</label>
          <input type="text" name="login" value="">
        </div>
        <div class="contentForm">
          <label for="email">email* :</label>
          <input type="text" name="email" value="">
        </div>
        <div class="contentForm">
          <label for="password">Mot de Passe* :</label>
          <input type="password" name="password" value="">
        </div>
        <div class="contentForm">
          <label for="cf-password">Confirmer votre Mot de Passe* :</label>
          <input type="password" name="cf-password" value="">
        </div>
        <div class="contentForm">
          <label for="sendButton"></label>
          <input type="submit" name="sendButton" value="Valider">
        </div>
      </form>
    </div>
  </body>
</html>
