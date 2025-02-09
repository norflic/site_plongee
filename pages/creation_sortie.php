<?php
include 'header.php';
require '../functions/accounts.php';
connexion_rederector();
require '../functions/bdd.php';
if (!empty($_POST)) {
    $myself = get_myself();
    if($myself != false){
        create_table_sorties();
        cree_sortie(
            $_POST['nom'],
            $_POST['participants_max'],
            $_POST['prix'],
            $_POST['lieu'],
            $_POST['description'],
            $myself['id']
//        $_POST['organisateur']
        );

        header("Location: creation_sortie.php");
    }
}

?>
<body>
<?php
include 'navBar.php';
?>
<form
    action=""
    method="POST">
    <label>Nom :
        <input value="name" type="text" name="nom" required><br><br>
    </label>
    <label>participants max :
        <input value="10" type="number" name="participants_max" required><br><br>
    </label>
    <label>prix :
        <input value="50" type="text" name="prix" required><br><br>
    </label>
    <label>Lieu :
        <input value="piscine buclos" type="text" name="lieu" required><br><br>
    </label>
    <label>Description :
        <textarea name="description" required></textarea><br><br>
    </label>
<!--    <label>Image :-->
<!--        <input type="file" name="image" accept="image/*"><br><br>-->
<!--    </label>-->

    <input type="submit" value="Envoyer">
</form>
<!--sql lite-->
<script src="apiAdresse.js"></script>
</body>
</html>