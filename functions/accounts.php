<?php

function cree_session($nom, $prenom, $mdp) :bool
{
//    var_dump("je crée une session, post =");
//    var_dump($_POST);
//    var_dump("fin du message");
    $user = get_user($_POST['nom'], $_POST['prenom'], $_POST['mdp']);

    if ($user == false){
        var_dump("aucun utilisateur enregistré dans la bd n'a ces infos");
        var_dump($user);
        return false;
    } else {
        $_SESSION['nom'] = $_POST['nom'];
        $_SESSION['prenom'] = $_POST['prenom'];
        $_SESSION['mdp'] = $_POST['mdp'];
        $_SESSION['id'] = $user['id'];
        return true;
    }
}


/**
 * necessite un mot de passe haché
 * compare les variables de session aux valeurs de la bd
 * renvoie true si il existe des resultat similaire
 * @param string $nom
 * @param string $prenom
 * @param string $password
 * @return bool
 */
function is_connected() :bool{

    $user = get_user($_SESSION['nom'] , $_SESSION['prenom'], $_SESSION['mdp']);
    if ($user->rowCount()>0){
        return true;
    }
//    TODO : renvoyer sur la page de connexion
    return false;

}

?>
