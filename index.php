<?php
  require 'config.php';
  var_dump($_SESSION);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>PHP - Session</title>
    <link rel="stylesheet" href="css/style.css" media="screen" title="no title" charset="utf-8">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
  </head>
  <body>
    <div id="background">
      <?php
      $valid = true;
      if(!isset($_SESSION['id'])){
      ?>
          <form method="POST">
            <fieldset>
              <legend>Inscription</legend>
              <div class="contentForm">
                <label for="login">Login* :</label>
                <input type="text" name="login" value="">
                <?php
                  if (isset($_POST['sendButton']) && empty($_POST['login']) && ($_POST['login'] < 2 || $_POST['login'] > 255)) {
                    echo "<p style='color: red'>Erreur. Vous devez créer un login compris entre 2 et 255 caractères.</p>";
                    $valid = false;
                  }
                ?>
              </div>
              <div class="contentForm">
                <label for="email">Email* :</label>
                <input type="text" name="email" value="">
                <?php
                  if (isset($_POST['sendButton']) && empty($_POST['email']) && (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))) {
                    $valid = false;
                    echo "<p style='color: red'>Erreur. Vous devez créer un email valide.</p>";
                  }
                ?>
              </div>
              <div class="contentForm">
                <label for="password">Mot de Passe* :</label>
                <input type="password" name="password" value="">
                <?php
                  if (isset($_POST['sendButton']) && empty($_POST['login']) && ($_POST['password'] < 2 || $_POST['password'] > 255)) {
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
              <div class="contentFormButton">
                <label for="sendButton"></label>
                <input type="submit" name="sendButton" value="Valider">
              </div>
            </fieldset>
            <?php }else{ ?>
	             <p class='flashAnswer' style='text-align: center; color: green;'> Bonjour <?php echo $_SESSION['login']; ?></p>
               <a href="logout.php">Se déconnecter</a>
            <?php } ?>
            <?php
              if (isset($_POST['sendButton']) && $valid = true) {
                $options = array('cost' => 10);
                $login = trim($_POST['login']);
                $email = trim($_POST['email']);
                $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT, $options);
                $date = time();

                $query = $db->prepare("SELECT * FROM users WHERE login = :login");
                $query->bindValue(":login", $login, PDO::PARAM_STR);
                $query->execute();
                if (!$query->rowCount()) {
                  $query = $db->prepare("INSERT INTO users(login, email, password, date) VALUES(:login, :email, :password, :date)");
                  $query->bindValue(':login', $login, PDO::PARAM_STR);
                  $query->bindValue(':email', $email, PDO::PARAM_STR);
                  $query->bindValue(':password', $password, PDO::PARAM_STR);
                  $query->bindValue(':date', $date, PDO::PARAM_STR);
                  $query->execute();
                }
                else {
                  echo "<p class='error' style='color: red;'>Erreur ! Ce nom d'utilisateur est déjà pris.</p>";
                }
              }
            ?>
          </form>
    </div>
    <div id="backgroundAuth">
      <form method="POST">
        <fieldset>
          <legend>Authentification</legend>
          <div class="content">
            <label for="nameAut">Login :</label>
            <input type="text" name="nameAut">
          </div>
          <div class="content">
            <label for="passwordAut">Mot de Passe :</label>
            <input type="password" name="passwordAut">
          </div>
          <div class="contentSubmitAut">
            <label for="submitAut"></label>
            <input type="submit" name="submitAut" value="C'est Parti !">
          </div>
          <?php
            if (isset($_POST['submitAut'])) {
              $login = $_POST['nameAut'];
              $password = $_POST['passwordAut'];
              if (!empty($login) && !empty($password)) {
                $query = $db->prepare("SELECT * FROM users WHERE login = :login");
                $query->bindValue(":login", $login, PDO::PARAM_STR);
                $query->execute();
                if ($query->rowCount()) {
                  $user = $query->fetch();
                  $valid = password_verify($password, $user['password']);
                  if ($valid) {
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['login'] = $user['login'];
                    header("Location: ".$url);
                  }
                  else {
                    echo "Erreur. Veuillez vous enregistrer ou verifier vos données.";
                  }
                }
              }
            }
          ?>
        </fieldset>
      </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.0.0.min.js" charset="utf-8"></script>
    <script src="js/script.js" charset="utf-8"></script>
  </body>
</html>
