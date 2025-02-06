<?php
require '../functions/verification.php';
session_start();
function verif_all()
{
    if (empty($_POST['ville'])
        || empty($_POST['code_postal'])
        || empty($_POST['nom_rue'])
        || empty($_POST['no_rue'])
        || empty($_POST['pays'])
        || empty($_POST['e_mail'])
        || empty($_POST['no_tel'])) {
        print("l'un des chaps n'est pas rempli");
        return false;
    } else {
        if (verif_adresse()
            && verif_email()
            && verif_no_tel()) {
            return true;
        } else {
            var_dump("Vérification de l'adresse : " . verif_adresse());
            var_dump("Vérification de l'email : " . verif_email());
            var_dump("Vérification du numéro de téléphone : " . verif_no_tel());
        }
    }
}

if (!empty($_POST)) {
    if (!verif_all()){
        var_dump("c'est pas rempli");
        header("Location: inscription_s1.php");
    } else {
//        print("execution des requetes");
        create_table_users();
        insertInto();
        $succes_creation_compte =cree_session($_POST['nom'], $_POST['prenom'], $_POST['mdp']);
        if ($succes_creation_compte) {
            var_dump("je me deplace");
            header("Location: accueil.php");
            exit;
        } else {
            var_dump("je me deplace pas");
            echo "Une ou plusieurs vérifications ont échoué. Veuillez corriger les erreurs.";
            header("Location: inscription_s1.php");
        }

    }
}
?>

<body>
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
<label>Email :
    <input type="email" value="rtegrfzed@gmail.com" id="e_mail" name="e_mail" required><br><br>
</label>
<label>numero tel :
    <input type="tel" value="0781881567" id="no_tel" name="no_tel" required><br><br>
</label>
</body>