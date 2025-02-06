<?php
include 'header.php';
require '../functions/bdd.php';
session_start();
function nb_equipements_valides(){
    $regex = "/[0-9]/";
    if (preg_match($regex, $_POST['nb_stabes'])
    && preg_match($regex, $_POST['nb_blocs'])
    && preg_match($regex, $_POST['nb_combinaisons'])
    && preg_match($regex, $_POST['nb_detendeurs'])) {
    }
}
if (!empty($_POST)) {
    $user = get_myself();
    if ($user != false) {
        $sortie = get_sortie($_GET["id_sortie"]);
        if ($sortie == false) {
            header("Location:accueil.php");
        } else {
            create_table_sortie_users();
            inscription_sortie($user['id'], $_GET["id_sortie"]);
            ajoute_materiel($user['id'], $_GET["id_sortie"],"stabe", $_POST['taille_stabes'], $_POST['nb_stabes']);
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
function generate_select($type) {
    if ($type == "taille") {
        generate_select_stabe();
    } elseif ($type == "bloc") {
        generate_select_bloc();
    } elseif ($type == "combinaison") {
        generate_select_type_combinaison();
    } elseif ($type == "detendeur") {
        generate_select_type_detendeur();
    } else {
        echo "Type de sélection invalide.";
    }
}


// TODO : préférences taille materiel
// TODO : choisir plusieurs tailles en 1 requete
function generate_select_stabe() {
    echo '
        <select name="taille_stabes">
            <option value="XS">XS</option>
            <option value="S">S</option>
            <option value="M">M</option>
            <option value="L">L</option>
            <option value="XL">XL</option>
            <option value="XXL">XXL</option>
            <option value="XXXL">XXXL</option>
            <option value="10XL">10XL</option>
        </select>
    ';
}
function generate_select_bloc() {
    echo '
        <select name="taille_bloc">
            <option value="9L">9L</option>
            <option value="12L">12L</option>
            <option value="15L">15L</option>
            <option value="18L">18L</option>
        </select>
    ';
}
function generate_select_type_combinaison() {
    echo '
        <select name="taille_combi">
            <option value="XS">XS</option>
            <option value="S">S</option>
            <option value="M">M</option>
            <option value="L">L</option>
            <option value="XL">XL</option>
            <option value="XXL">XXL</option>
            <option value="XXXL">XXXL</option>
            <option value="10XL">10XL</option>
        </select>
    ';
}
function generate_select_type_detendeur() {
    echo '
        <select name="type_detendeur">
            <option value="XS">XS</option>
            <option value="S">S</option>
            <option value="M">M</option>
            <option value="L">L</option>
            <option value="XL">XL</option>
            <option value="XXL">XXL</option>
            <option value="XXXL">XXXL</option>
            <option value="10XL">10XL</option>
        </select>
    ';
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
            <input type="number" value="0" name="nb_stabes">
            <?php generate_select("taille"); ?>
        </label>
        <label>nb_blocs
            <input type="number" value="0" name="nb_blocs">
            <?php generate_select("bloc"); ?>
        </label>

        <label>nb_detendeurs
            <input type="number" value="0" name="nb_detendeurs">
            <?php generate_select("detendeur"); ?>
        </label>

        <label>nb_combinaisons
            <input type="number" value="0" name="nb_combinaisons">
            <?php generate_select("combinaison"); ?>
        </label>

        <input type="submit" id="btnSubmit" value="rejoindre"/>
    </form>
</div>
