<?php
include 'header.php';
require '../functions/accounts.php';
require '../functions/bdd.php';
require '../functions/verification.php';

function verif_all()
{
    if (empty($_POST['nom'])
        || empty($_POST['prenom'])
        || empty($_POST['mdp'])) {
        print("l'un des chaps n'est pas rempli");
        return false;
    } else {
        if (verif_name()
            && verif_prenom()) {
            return true;
        } else {
            var_dump("Vérification du nom : " . verif_name());
            var_dump("Vérification du prénom : " . verif_prenom());
        }
    }
    return false;
}

if (!empty($_POST)) {
    if (!verif_all()) {
        var_dump("c'est pas rempli");
    } else {
        session_start();
        $_SESSION['tmp_nom'] = $_POST['nom'];
        $_SESSION['tmp_prenom'] = $_POST['prenom'];
        $_SESSION['tmp_mdp'] = $_POST['mdp'];
        header("Location: inscription_s2.php");
    }
}

?>

<body>
    <p class="desc_etape">Etape 1 (inscription) :</p>
<form action=""
      method="POST">
    <label>Nom :
        <input value="Derrien" type="text" name="nom" required>
    </label>
    <label>Prenom :
        <input value="Nils" type="text" name="prenom" required>
    </label>
    <label>mot de passe :
        <input value="1234" type="password" name="mdp" required>
    </label>
    <input type="submit" value="suivant">
</form>
<!--sql lite-->
<script src="apiAdresse.js"></script>
</body>
</html>