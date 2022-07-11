<?php
session_start();
require_once("./pdo.php");
$salt='XyZzy12\*\_';

if(isset($_POST['login'])) {
  if(!empty($_POST['name']) && !empty($_POST['pass'])) { 
    $name= htmlentities($_POST['name']);
    $pass= htmlentities($_POST['pass']);
    $pass = sha1($_POST['pass']);
    
    $namedb = $pdo->prepare("SELECT * FROM users WHERE name = :name AND password = :pass");
    $namedb->execute([
      ":name" => $name,
      ":pass" => $pass,
    ]);
    $result = $namedb->fetch();
    $userExist=$namedb->rowCount();

    if ($userExist == 1) {
      $_SESSION["user"] = $name;
      $_SESSION["user_id"] = $result["user_id"];
      header("Location: ./app.php");
    } else {
      echo "Identifiants incorrects";
      echo $name;
    } 
  } 
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'instruction include</title>
</head>
<body>
  <div class="container">
    <form method="POST" class="form">
      <h1> Connectez-vous</h1>  
      <div class="form-group">
        <label for="nom">Nom D'utilisateur :</label><br>
        <input type="text" class="form-control" id="name" name="name">
      </div>

      <!--mot de passe-->
      <div class="form-group">
        <label for="text">Mot de passe :</label><br>
        <input type="pass" class="form-control" id="pass" name="pass">
      </div>    

      <!-- bouton-->
      <button type="submit" name="login"  class="btn btn-sucess btn-block btn-lg mb-2">se connecter</button><br>
    </form>
    <a href="./index.php" class="btn">Annuler</a>
  </div>
</body>
</html>