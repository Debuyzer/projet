<?php 
session_start();
require_once("./pdo.php");


$name=$_POST ["name"] ?? "";
$message=false;
$password = $_POST["pass"] ?? "";
$confirmPassword = $_POST["pass2"] ?? "";
$salt='XyZzy12\*\_';



if(isset($_POST['name']) && isset($_POST['pass']) && isset($_POST['pass2'])) {
  if(!empty($_POST['name']) && !empty($_POST['pass']) && !empty($_POST['pass2'])){
    $name= htmlentities($_POST['name']);
    $password= htmlentities($_POST['pass']);
    $confirmPassword= htmlentities($_POST['pass2']);
    $password = sha1($_POST['pass']);
    
    echo "tout les champs on été remplis";
    $namedb =$pdo->prepare("SELECT * FROM users WHERE name=:name");
    $namedb->execute([
      ":name"=> $name,
    ]);

    $user= $namedb->fetch(PDO::FETCH_ASSOC);
    if($user ){
         $error="Le nom existe deja";

    } else{
       $insert=$pdo->prepare("INSERT INTO users(name,password) VALUES(:name, :pass)");
        $insert->execute([
          ":name" => $name,
          ":pass" => $password,
        ]); 
    }
}else{
    $error = "veuillez remplir tous les champs";
  }
          }
        
     else {
        $error= "Vous n'avez pas entrer le mots de passe identique veuillez réessayer";
     }
   
   
  
  ?>
  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrez</title>
</head>
<body>

  <form method="POST">

    <h4 class="text">Enregistrez-vous</h4>
    <p style="color:red"><?php if(isset($error)){ echo $error; unset($error);}  ?>  </p>
    <div class="form-group">
      <label for="nom">Nom D'utilisateur :</label><br>
      <input type="text" class="form-control" id="nom" name="name">
    </div>
      <!-- mot de passe -->

    <div class="form-group">
      <label for="email">Mot de passe :</label><br>
      <input type="pass" class="form-control" id="pass" name="pass">

    </div>


    <div class="form-group">
      <label for="password-repeat">Confirme Le Mot De Passe :</label><br>
      <input type="password" class="form-control" id="pass-repeat" name="pass2"><br>
    </div>

    <!-- bouton-->
    <button  type="submit" class="btn btn-sucess btn-block btn-lg mb-2">s'enregistrez</button> 
  </form>

  <a href="./logout.php" class="btn">Annuler</a>         
</body>
</html>
