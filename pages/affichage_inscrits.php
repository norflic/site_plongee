<?php
require '../functions/bdd.php';
//$id_sortie = $_GET["id_sortie"];
$sortie = get_sortie(1);
$sortie_users = get_sortie_users(1);
$organisateur = get_user_by_id($sortie['organisateur']);
for ($i = 0; $i < count($sortie_users); $i++) {
    $sortie_users[$i] = get_user_by_id($sortie_users[$i]['id_user']);
}

require '../pages/header.php';
?>
infos des incrits (dp en rouge):
    <table>
        <tr>
            <th>Nom / prenom</th>
            <th>email</th>
            <th>no_tel</th>
        </tr>
        <tr class="tab_organisateur">
            <td><?php echo $organisateur['nom'] . " " . $organisateur['prenom']  ?></td>
            <td><?php echo $organisateur['e_mail']; ?></td>
            <td><?php echo $organisateur['no_tel']; ?></td>
        </tr>


<?php
for ($i = 0; $i < count($sortie_users); $i++) {
    echo "
    <tr>
        <td>" . $sortie_users[$i]['nom'] . " " . $sortie_users[$i]['prenom']. "</td>
        <td>" . $sortie_users[$i]['e_mail'] . "</td>
        <td>" . $sortie_users[$i]['no_tel'] . "</td>

    </tr>";
}


?>
    </table>
<!--<td>-->
<!--    " .  $sortie_users[$i]['mode_paiement'] != null ? $sortie_users[$i]['e_mail'] : 'NULL' . "-->
<!--</td>-->