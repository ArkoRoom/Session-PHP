<?php
  require 'config.php';
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Mot de Passe oublié ?</title>
    <link rel="stylesheet" href="css/style.css" media="screen" title="no title" charset="utf-8">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
  </head>
  <body>
    <div id="backgroundForget">
      <fieldset>
        <legend>Mot de Passe oublié</legend>
        <form class="formForget" method="POST">
          <div class="contentForget">
            <label for="forgetLogin">Login : </label>
            <input type="text" name="forgetLogin">
          </div>
          <div class="contentForget">
            <label for="forgetSubmit"></label>
            <input type="submit" name="forgetSubmit" value="Envoyer">
          </div>
        </form>
      </fieldset>
      <?php
        if (isset($_POST['forgetSubmit'])) {
          $login = $_POST['forgetLogin'];
          $checkUser = $db->prepare("SELECT * FROM users WHERE login = :login");
          $checkUser->bindValue(':login', $login, PDO::PARAM_STR);
          $checkUser->execute();
          if ($checkUser->rowCount()) {
            $forget = sha1(md5(uniqid().$_SERVER['REMOTE_ADDR']));
            $db->query("UPDATE users SET forget = '$forget' WHERE login = '".$login."'");
            echo "<p class='answerForget'>Bonjour ".$login.", vous pouvez redéfinir votre Mot de Passe sur </p><a href='".$url."?forget=".$forget."'>".$url."?forget=".$forget."</a>";
          }
          else {
            echo "L'utilisateur saisie n'existe pas.";
          }
        }
      ?>
    </div>
  </body>
</html>
