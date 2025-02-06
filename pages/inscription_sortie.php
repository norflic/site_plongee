<?php
include 'header.php';
require '../functions/bdd.php';
session_start();

if (!empty($_POST)) {
    $user = get_myself();
    if ($user != false) {
        $sortie = get_sortie($_GET["id_sortie"]);
        if ($sortie == false) {
            header("Location:accueil.php");
        } else {
            create_table_sortie_users();
            inscription_sortie($user['id'], $_GET["id_sortie"]);

        }
    } else {
        header("Location:connexion.php");
    }
}
$sortie = get_sortie($_GET["id_sortie"]);
if ($sortie) {
    $nom = $sortie['nom'];
    $nombre_participants = $sortie['lieu'];
    $lieu = $sortie['lieu'];
    $prix = $sortie['prix'];
    $desc = $sortie['description'];
    $organisateur = $sortie['organisateur'];
} else {
    die("message erreur");
}


?>
<div>
    <div class="description_sortie">
        <div><?= $nom ?></div>
        <div><?= $lieu ?></div>
        <div><?= $prix ?></div>
        <div><?= $desc ?></div>
    </div>

    <form
            action=""
            method="POST">
        <label>nb_stabes
            <input type="number" value="nb_stabes" name="nb_stabes">
        </label>
        <label>nb_blocs
            <input type="number" value="nb_blocs" name="nb_blocs">
        </label>
        <label>nb_detendeurs
            <input type="number" value="nb_detendeurs" name="nb_detendeurs">
        </label>
        <label>nb_combinaisons
            <input type="number" value="nb_combinaisons" name="nb_combinaisons">
        </label>

        <input type="submit" id="btnSubmit" value="rejoindre"/>
    </form>
</div>
