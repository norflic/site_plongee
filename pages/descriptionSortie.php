<?php
require '../functions/bdd.php';
session_start();

if (!empty($_POST)) {
    $user = get_myself();
    if($user != false){
        create_table_sortie_users();
        inscription_sortie($user['id'], $_GET["id_sortie"]);
    }
}
?>
<div>
    <form
        action=""
        method="POST">
        <input type="hidden" value="coucou" name="coucou">

        <input type="submit" id="btnSubmit" value="rejoindre"/>
    </form>
</div>
