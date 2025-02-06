<?php
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
?>
