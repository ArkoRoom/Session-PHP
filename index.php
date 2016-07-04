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
      <?php $valid = true; ?>
      <fieldset>
        <legend>Inscription</legend>
          <form method="POST">
            <div class="contentForm">
              <label for="login">Login* :</label>
              <input type="text" name="login" value="">
              <?php
                if (isset($_POST['sendButton']) && ($_POST['login'] < 2 || $_POST['login'] > 255)) {
                  echo "<p style='color: red'>Erreur. Vous devez créer un login compris entre 2 et 255 caractères.</p>";
                  $valid = false;
                }
              ?>
            </div>
            <div class="contentForm">
              <label for="email">Email* :</label>
              <input type="text" name="email" value="">
              <?php
                if (isset($_POST['sendButton']) && empty($_POST['email']) && (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))) {
                  $valid = false;
                  echo "<p style='color: red'>Erreur. Vous devez créer un email valide.</p>";
                }
              ?>
            </div>
            <div class="contentForm">
              <label for="password">Mot de Passe* :</label>
              <input type="password" name="password" value="">
              <?php
                if (isset($_POST['sendButton']) && ($_POST['password'] < 2 || $_POST['password'] > 255)) {
                  echo "<p style='color: red'>Erreur. Vous devez créer un mot de passe compris entre 2 et 255 caractères.</p>";
                  $valid = false;
                }
              ?>
            </div>
            <div class="contentForm">
              <label for="cf-password">Confirmer votre Mot de Passe* :</label>
              <input type="password" name="cf-password" value="">
              <?php
                if (isset($_POST['sendButton']) && ($_POST['password'] != $_POST['cf-password'])) {
                  echo "<p style='color: red'>Erreur. Vos deux mot de passe doivent correspondre.</p>";
                  $valid = false;
                }
              ?>
            </div>
            <div class="contentForm">
              <label for="sendButton"></label>
              <input type="submit" name="sendButton" value="Valider">
            </div>
          </form>
      </fieldset>
    </div>
    <?php
    $options = array('cost' => 10);
      if (isset($_POST['sendButton']) && $valid = true) {
        $login = $_POST['login'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT, $options);
        $date = time();

        $query = $db->prepare("INSERT INTO users(login, email, password, date) VALUES(:login, :email, :password, :date)");
        $query->bindValue(':login', $login, PDO::PARAM_STR);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->bindValue(':password', $password, PDO::PARAM_STR);
        $query->bindValue(':date', $date, PDO::PARAM_STR);
        $query->execute();
      }
    ?>
  </body>
</html>
