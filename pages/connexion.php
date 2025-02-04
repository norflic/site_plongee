<?php
require '../functions/accounts.php';
require '../functions/bdd.php';
if (!empty($_POST)) {
    if (!get_user($_POST['nom'], $_POST['prenom'], $_POST['mdp'])) {
        var_dump("vous n'existez pas");
    } else {
        if(!cree_session($_POST['nom'], $_POST['prenom'], $_POST['mdp'])){
            var_dump("vous n'existez pas et c'est pas normal");
        }
        header("Location: accueil.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<form
    action=""
    method="POST">
    <label>Nom :
        <input value="name" type="text" name="nom" required><br><br>
    </label>
    <label>Prenom :
        <input value="prenom" type="text" name="prenom" required><br><br>
    </label>
    <label>mot de passe :
        <input value="1234" type="password" name="mdp" required><br><br>
    </label>
    <input type="submit" value="Envoyer">
</form>
</body>
</html>