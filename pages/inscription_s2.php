<?php
session_start();
require '../functions/verification.php';
require '../functions/bdd.php';
require '../functions/accounts.php';
require 'header.php';
function verif_all()
{
    if (empty($_POST['date_naissance'])
        || empty($_POST['date_certif'])
        || empty($_FILES['caci'])) {
        print("l'un des chaps n'est pas rempli");
        return false;
    } else {
        if (verif_naissance()
            && verif_date_certif()
            && fichier_valide()) {
            return true;
        } else {
            var_dump("Vérification de la date de naissance : " . verif_naissance());
            var_dump("Vérification de la date de certification : " . verif_date_certif());
            var_dump("Vérification du fichier : " . fichier_valide());
        }
    }
    return false;
}

// TODO : mettre l'id dans le nom de fichier pour empecher les remplacements
// TODO : mettre comme nom id+"CACI"format
// TODO : rajouter colonne nom de fichier
function fichier_valide()
{
    $message_errreur = "";
    if ($_FILES['caci'] && $_FILES['caci']['error'] == 0) {
        $temp_name = $_FILES['caci']['tmp_name'];
//        var_dump($_FILES['caci']['tmp_name']);

        if (!is_uploaded_file($temp_name)) {
            $message_errreur = "le fichier est introuvable";
        }
        if ($_FILES['caci']['size'] > 5000000) {
            $message_errreur = "le fichier est trop volumineux";
        }
        // vérification des extensions
        $infosfichier = pathinfo($_FILES['caci']['name']);
        $extension_upload = $infosfichier['extension'];
        $extension_upload = strtolower($extension_upload);
        $extensions_autorisees = array('pdf', 'jpg', 'jpeg', 'png');
        if (!in_array($extension_upload, $extensions_autorisees)) {
            $message_errreur = "Le format du fichier est incorrect";
        }
        if ($message_errreur == "") {
            return true;
        }
    }
    exit($message_errreur);
}

function get_chemin_fichier()
{
    if (fichier_valide()) {
        $uploads_dir = '../uploads';
        $tmp_name = $_FILES["caci"]["tmp_name"];
        $destination = $uploads_dir . '/' . $_FILES["caci"]["name"];
        var_dump($destination);
        if (!move_uploaded_file($tmp_name, $destination)) {
            var_dump("debut, dest");
            var_dump($tmp_name);
            var_dump($destination);
            exit("probleme durant le telechargement de l'image");
        }
        return $destination;
    } else {
        return "chemin_inconnu";
    }
}

if (!empty($_POST)) {
    if (!verif_all()) {
        var_dump("c'est pas rempli");
    } else {
//        print("execution des requetes");
        create_table_users();
        insertInto_s1_2();
        $succes_creation_compte = cree_session($_SESSION['tmp_nom'], $_SESSION['tmp_prenom'], $_SESSION['tmp_mdp']);
        if ($succes_creation_compte) {
            var_dump("je me deplace");
            header("Location: inscription_s3.php");
            exit;
        } else {
            var_dump("je me deplace pas");
            echo "Une ou plusieurs vérifications ont échoué. Veuillez corriger les erreurs.";
        }

    }
}
?>

<body>
    <a href="inscription_s1.php">etape precedente</a>
    <p class="desc_etape">Etape 2 (administratif) :</p>
<form
        action=""
        method="POST" enctype="multipart/form-data">
    <label >date de naissance :
        <input type="date" value="2020-05-05" name="date_naissance" required>
    </label>
    <label >niveau :
        <select id="niveau" name="niveau">
            <option value="N1">Niveau 1</option>
            <option value="N2">Niveau 2</option>
            <option value="N3">Niveau 3</option>
            <option value="PA40">Plongeur Autonome 40m</option>
            <option value="GP">Guide de Palanquée (N4)</option>
            <option value="E1">Encadrant Niveau 1</option>
            <option value="E2">Encadrant Niveau 2</option>
            <option value="E3">Encadrant Niveau 3</option>
            <option value="E4">Encadrant Niveau 4</option>
        </select>
    </label>

    <label>date de création de certificat medical :
        <input type="date" value="2024-09-09" name="date_certif" required>
    </label>
    <label>CACI (certificat d'aptitude) :
        <input type="file" value="" id="caci" name="caci" required>
    </label>
    <input type="submit" value="suivant">
</form>
</body>