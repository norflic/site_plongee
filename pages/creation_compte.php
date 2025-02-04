<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<?php
session_start();
require '../functions/accounts.php';
require '../functions/bdd.php';
// Si le tableau $POST existe alors le formulaire a été envoyé
function verif_name(): bool
{
    return true;
}
function verif_prenom(): bool
{
    return true;
}
function verif_naissance(): bool
{
    return true;
}
function verif_adresse(): bool
{
    $regex_cp_no_rue = "/[0-9]/";
    $regex_ville_nom_rue_pays = "/^[a-zA-ZÀ-ÿ\s\-]+$/";
    if (preg_match($regex_cp_no_rue, $_POST['code_postal']) && preg_match($regex_cp_no_rue, $_POST['no_rue'])) {
        if (preg_match($regex_ville_nom_rue_pays, $_POST['ville'])
            && preg_match($regex_ville_nom_rue_pays, $_POST['pays'])
            && preg_match($regex_ville_nom_rue_pays, $_POST['nom_rue'])) {
            return true;
        }
    }
    var_dump("l'ude des données de l'adresse est invalide");
    var_dump("Code postal validation : ", preg_match($regex_cp_no_rue, $_POST['code_postal']));
    var_dump("Numéro de rue validation : ", preg_match($regex_cp_no_rue, $_POST['no_rue']));
    var_dump("Ville validation : ", preg_match($regex_ville_nom_rue_pays, $_POST['ville']));
    var_dump("Pays validation : ", preg_match($regex_ville_nom_rue_pays, $_POST['pays']));
    var_dump("Nom de rue validation : ", preg_match($regex_ville_nom_rue_pays, $_POST['nom_rue']));
    return false;
}
function verif_date_certif(): bool
{
    $ajd = new DateTime();  // Initialisation de la date actuelle
    $date_certif = new DateTime($_POST['date_certif']);
    $diff_sec = $ajd->getTimestamp() - $date_certif->getTimestamp() ;
    $diff_annee = $diff_sec/(3600*24*365.25);
//    var_dump("date depuis la certif = ".$diff_annee. " années");
    if($diff_annee < 1){
        return true;
    } else {
        return false;
    }
//    TODO: inserer validite de caci dans la bd
//    TODO : faire vérifier date mise manuellement et le faire modifier
}
function verif_no_tel(): bool
{
    $no_tel = str_replace(" ", "", $_POST['no_tel'] );
    $no_tel = str_replace("-", "", $no_tel);
    $regex = "/^\d{10}$/";
    if (preg_match($regex, $no_tel)){
        return true;
    } else {
        var_dump("no tel faux :".$no_tel);
        return false;
    }
}
function verif_email(): bool
{
    return (filter_var($_POST['e_mail'], FILTER_VALIDATE_EMAIL));
}
function verif_all(){
if (empty($_POST['nom'])
    || empty($_POST['prenom'])
    || empty($_POST['date_naissance'])
    || empty($_POST['ville'])
    || empty($_POST['code_postal'])
    || empty($_POST['nom_rue'])
    || empty($_POST['no_rue'])
    || empty($_POST['pays'])
    || empty($_POST['e_mail'])
    || empty($_POST['date_certif'])
    || empty($_POST['no_tel'])
    || empty($_FILES['caci']))
    {
        $message = "l'un des chaps n'est pas rempli";
        print($message);
        return false;
    } else {
        if (verif_name()
            && verif_prenom()
            && verif_naissance()
            && verif_adresse()
            && verif_email()
            && verif_naissance()
            && verif_date_certif()
            && verif_no_tel()
            && fichier_valide()) {
            return true;
        } else {
            var_dump("Vérification du nom : ". verif_name());
            var_dump("Vérification du prénom : ". verif_prenom());
            var_dump("Vérification de la date de naissance : ". verif_naissance());
            var_dump("Vérification de l'adresse : ". verif_adresse());
            var_dump("Vérification de l'email : ". verif_email());
            var_dump("Vérification de la date de naissance : ". verif_naissance());
            var_dump("Vérification de la date de certification : ". verif_date_certif());
            var_dump("Vérification du numéro de téléphone : ". verif_no_tel());
            var_dump("Vérification du fichier : ". fichier_valide());
        }
}
return false;
}


// TODO : mettre l'id dans le nom de fichier pour empecher les remplacements
// TODO : mettre comme nom id+"CACI"format
// TODO : rajouter colonne nom de fichier
function fichier_valide(){
    $message_errreur = "";
    if ($_FILES['caci'] && $_FILES['caci']['error'] == 0) {
        $temp_name = $_FILES['caci']['tmp_name'];
        var_dump($_FILES['caci']['tmp_name']);

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
    if (fichier_valide()){
        $uploads_dir = '../uploads';
    $tmp_name = $_FILES["caci"]["tmp_name"];
    $destination = $uploads_dir . '/' . $_FILES["caci"]["name"];
    var_dump($destination);
    if (!move_uploaded_file($tmp_name, $destination)){
        exit("probleme durant le telechargement de l'image");
    }
    return $destination;
    } else {
        return "chemin_inconnu";
    }
}


if (!empty($_POST)) {
    if (!verif_all()){
        var_dump("c'est pas rempli");
        header("Location: creation_compte.php");
    } else {
//        print("execution des requetes");
        create_table();
        insertInto();
        $succes_creation_compte =cree_session($_POST['nom'], $_POST['prenom'], $_POST['mdp']);
        if ($succes_creation_compte) {
            var_dump("je me deplace");
            header("Location: accueil.php");
            exit;
        } else {
            var_dump("je me deplace pas");
            echo "Une ou plusieurs vérifications ont échoué. Veuillez corriger les erreurs.";
            header("Location: creation_compte.php");
        }

}
}

?>
<body>
<form
        action=""
        method="POST" enctype="multipart/form-data">
    <label>Nom :
        <input value="name" type="text" name="nom" required><br><br>
    </label>
    <label>Prenom :
        <input value="prenom" type="text" name="prenom" required><br><br>
    </label>
    <label>mot de passe :
        <input value="1234" type="password" name="mdp" required><br><br>
    </label>

    <label for="date_naissance">date de naissance :
        <input type="date" value="2020-05-05" name="date_naissance" required><br><br>
    </label>

    <fieldset>
        <legend>adresse</legend>
        <label>numero de rue :
            <input type="text" value="100" name="no_rue" required><br><br>
        </label>
        <label for="cp">
            Code postal
            <input type="text" value="0" id="code_postal" name="code_postal"
                   placeholder="Enter your postal code here">
        </label>
        <label for="ville">
            Ville
            <select id="ville" name="ville">
                <option value="">Select ville</option>
            </select> <br/><br/>
        </label>
        <label>rue :
            <input type="text" value="cours random" name="nom_rue" required><br><br>
        </label>
        <label>pays :
            <input type="text" value="france" name="pays" required><br><br>
        </label>
    </fieldset>

    <label>date de création de certificat medical :
        <input type="date" value="2024-09-09" name="date_certif" required><br><br>
    </label>

    <label>Email :
        <input type="email" value="rtegrfzed@gmail.com" id="e_mail" name="e_mail" required><br><br>
    </label>
    <label>numero tel :
        <input type="tel" value="0781881567" id="no_tel" name="no_tel" required><br><br>
    </label>
    <label>CACI (certificat d'aptitude) :
        <input type="file" value="" id="caci" name="caci" required><br><br>
    </label>
    <!--    pdf ou jpeg-->
    <input type="submit" value="Envoyer">
</form>
<!--sql lite-->
<script src="apiAdresse.js"></script>
</body>
</html>