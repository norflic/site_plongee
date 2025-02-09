<?php
require '../functions/verification.php';
require '../functions/bdd.php';
require 'header.php';
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
    return false;
}

if (!empty($_POST)) {
    if (!verif_all()) {
        var_dump($_POST);
        var_dump("c'est pas rempli");
    } else {
//        print("execution des requetes");
        create_table_users();
        insertInto_s3($_SESSION['id']);
        header("Location: accueil.php");
        }
}
?>

<body>
<p class="desc_etape">Etape 3 (infos pratiques) :</p>
<form
        method="POST" enctype="multipart/form-data">
    <fieldset>
        <legend>adresse</legend>
        <label>numero de rue :
            <input type="text" value="100" name="no_rue" required>
        </label>
        <label for="cp">
            Code postal
            <input type="text" value="0" id="code_postal" name="code_postal"
                   placeholder="Enter your postal code here">
            <label for="ville">
                Ville
                <select id="ville" name="ville">
                    <option value="">Select ville</option>
                </select>
            </label>
        </label>

        <label>rue :
            <input type="text" value="cours random" name="nom_rue" required>
        </label>
        <label>pays :
            <input type="text" value="france" name="pays" required>
        </label>
    </fieldset>
    <label>Email :
        <input type="email" value="rtegrfzed@gmail.com" id="e_mail" name="e_mail" required>
    </label>
    <label>numero tel :
        <input type="tel" value="0781881567" id="no_tel" name="no_tel" required>
    </label>
    <input type="submit" value="suivant">
</form>
<script src="apiAdresse.js"></script>
</body>