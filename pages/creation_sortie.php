<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<?php
if (!empty($_POST)) {

}

?>
<body>
<form
    action=""
    method="POST" enctype="multipart/form-data">
    <label>Nom :
        <input value="name" type="text" name="nom" required><br><br>
    </label>
    <label>participants max :
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