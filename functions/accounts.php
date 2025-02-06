<?php
function cree_session($nom, $prenom, $mdp) :bool
{
//    var_dump("je crée une session, post =");
//    var_dump($_POST);
//    var_dump("fin du message");
    session_start();
    $user = get_user($nom, $prenom, $mdp);

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
 * si pas connecte, redirige vers connexion et renvoie true
 * sinon renvoie false
 * @return bool
 */
function connexion_rederector() :bool{
    $user = (!empty($_SESSION['nom']));
    if ($user == false){
        header("Location: connexion.php");
        return true;
    } else {
        return false;
    }
}

?>
