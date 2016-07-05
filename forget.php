<?php
  require 'config.php';
?>

<?php
  if (isset($_GET['forgetToken'])) {
    $forget = $_GET['forgetToken'];
    $checkToken = $db->prepare("SELECT * FROM users WHERE forget = :forget");
    $checkToken->bindValue(":forget", $forget, PDO::PARAM_STR);
    $checkToken->execute();
      if ($checkToken->rowCount()) { ?>
        <!DOCTYPE html>
        <html>
          <head>
            <meta charset="utf-8">
            <title>Mot de Passe oublié ?</title>
            <link rel="stylesheet" href="css/style.css" media="screen" title="no title" charset="utf-8">
            <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
          </head>
          <body>
            <form class="checkToken" method="POST">
              <div class="checkToken">
                <label for="new-password">Nouveau Mot de Passe :</label>
                <input type="password" name="new-password">
              </div>
              <div class="checkToken">
                <label for="confirm-new-password">Confirmez le nouveau Mot de Passe :</label>
                <input type="password" name="confirm-new-password">
              </div>
              <div class="checkToken">
                <label for="checkTokenSubmit"></label>
                <input type="submit" name="checkTokenSubmit" value="Confirmer">
              </div>
              <?php
                if (isset($_POST['checkTokenSubmit'])) {
                  $user = $checkToken->fetch();
                  $password = password_hash(trim($_POST['new-password']), PASSWORD_BCRYPT);
                  $query = $db->prepare("UPDATE users SET password = :password WHERE id = :id");
                  $query->bindValue(':password', $password, PDO::PARAM_STR);
                  $query->bindValue(':id', $user['id'], PDO::PARAM_INT);
                  if ($query->execute()) {
                    echo "Votre mot de passe à été mis à jour";
                  }
                }
              ?>
            </form>
    <?php  }else {
          echo "Erreur";
    }
  }
  else { ?>
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
  }
?>
      <?php
        if (isset($_POST['forgetSubmit'])) {
          $login = $_POST['forgetLogin'];
          $checkUser = $db->prepare("SELECT * FROM users WHERE login = :login");
          $checkUser->bindValue(':login', $login, PDO::PARAM_STR);
          $checkUser->execute();
          if ($checkUser->rowCount()) {
            $forget = sha1(md5(uniqid().$_SERVER['REMOTE_ADDR']));
            $now = new Datetime();
            $now->modify("+3 day");
            $date = $now->format('Y-m-d H:i:s');
            $db->query("UPDATE users SET forget = '$forget', dateForget = '$date' WHERE login = '".$login."'");
            echo "<p class='answerForget'>Bonjour ".$login.", vous pouvez redéfinir votre Mot de Passe sur </p><a href='".$url."?forgetToken=".$forget."'>".$url."?forgetToken=".$forget."</a>";
          }
          else {
            echo "L'utilisateur saisie n'existe pas.";
          }
        }
      ?>
    </div>
  </body>
</html>
