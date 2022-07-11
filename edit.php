<?php
session_start();
//connexion à la bdd
require_once("./pdo.php");


//On protege la page, si la personne n'est pas authentifiée, elle sort.
if (!isset($_SESSION["user_id"])) {
    die("utilisateur non authentifié");
}


$sql = "SELECT * FROM tasks WHERE task_id = :task_id";
$query = $pdo->prepare($sql);
$query->execute([
    ":task_id" => $_SESSION["task_id"]
]);
$result = $query->fetch(PDO::FETCH_ASSOC);
//On enregistre la correction lorsque on appuie sur enregistrer.
if (isset($_POST["save"])) {
    echo "save ";

    //On recupere les variables 
    $task_id = $_SESSION["task_id"];
    $title = $_POST["title"];

    $updateQuery = "UPDATE tasks SET title = :title WHERE task_id = :task_id";
    // On se protege contre les injection sql
    $query = $pdo->prepare($updateQuery);

    //On affiche un message et on retourne sur la page app.php
    $query->execute([
        ":task_id" => $task_id,
        ":title" => $title
    ]);
    $_SESSION["success"] = "Tache modifiée avec succes";
    header("Location: app.php");
    return;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="stylesheet" href="app.css">
        <link rel="stylesheet" href="styles.css">
        <title>Editer</title>
</head>

<body>
    <div class="container">
        <h3>Editer une Tâche</h3>
        <?php
        if (isset($_SESSION["error"])) {
            echo "<small style='color: red'>{$_SESSION["error"]}</small>";
            unset($_SESSION["error"]);
        }
        ?>
        <form method="POST">
            <input type="text" name="title" value="<?= $result["title"] ?>">
            <button class="btn btn-outline-secondary btn-sm" type="submit" name="save">Editer</button><br>
           
            <a href="./app.php">annuler</a>
        </form>

    </div>