<?php
require '../functions/bdd.php';
//$id_sortie = $_GET["id_sortie"];
$id_sortie = 1;
$sortie = get_sortie($id_sortie);
$sortie_users = get_sortie_users($id_sortie);
$organisateur = get_user_by_id($sortie['organisateur']);
$infos_peiement_organisateur = get_infos_paiement($id_sortie, $organisateur['id']);
for ($i = 0; $i < count($sortie_users); $i++) {
    $id_user = $sortie_users[$i]['id_user'];
    $sortie_users[$i] = get_user_by_id($id_user);
    $infos_paiement_users[$i] = get_infos_paiement($id_sortie, $id_user);
//    var_dump($infos_paiement_users[$i]);
}

/**
 * fais en sorte que la variable de la fonction apparaisse en premier dans le select
 * @param $type_actuel
 * @return string
 */
function select_type_paiement($type_actuel): string
{
    $types_paiement = [
        'null' => 'non_définie',
        'carte' => 'en cours (carte)',
        'liquide' => 'en cours (liquide)'
    ];

    $html = "<select name='type_paiement'>";

    // Ajouter l'option correspondant au type actuel en premier
    if ($type_actuel !== null && isset($types_paiement[$type_actuel])) {
        $html .= "<option value='$type_actuel' selected>{$types_paiement[$type_actuel]}</option>";
        unset($types_paiement[$type_actuel]);
    }

    // Ajouter les autres options
    foreach ($types_paiement as $value => $label) {
        $html .= "<option value='$value'>$label</option>";
    }

    $html .= "</select>";

    return $html; // Pas de echo ici
}


function select_date_paiement($ancienn_date): string
{
    if($ancienn_date == null){
        $html = "<label >
        <input type='date' value='null' name='date_paiement'>
        </label>";
    } else {
        $html = "<label >
        <input type='date' value='$ancienn_date' name='date_paiement'>
    </label>";
    }
    return $html;

}

function select_etat_paiement($ancien_etat): string
{
    if($ancien_etat == null){
        $html = "<label >
            <input type='text' value='null' name='etat_paiement'>
            </label>";
    } else {
        $html = "<label >
        <input type='text' value='$ancien_etat' name='etat_paiement'>
    </label>";
    }
    return $html;
}

if (!empty($_POST)) {
    var_dump($_POST);
    for($i = 0; $i < count($_POST); $i++) {

    }
}
require '../pages/header.php';
?>
<form action=""
      method="POST">
    infos des incrits (dp en rouge):
    <table>
        <tr>
            <th>Nom / prenom</th>
            <th>email</th>
            <th>no_tel</th>
            <th>type_paiement</th>
            <th>date_paiement</th>
            <th>etat_paiement</th>
        </tr>
        <?php
        echo "
    <input type='hidden' value='{$organisateur['id']}'>
    <tr class='tab_organisateur'>
        <td>" . $organisateur['nom'] . " " . $organisateur['prenom'] . "</td>
        <td>" . $organisateur['e_mail'] . "</td>
        <td>" . $organisateur['no_tel'] . "</td>
        <td>" . select_type_paiement($infos_peiement_organisateur['type_paiement']) . "</td>
        <td>" . select_date_paiement($infos_peiement_organisateur['date_paiement']) . "</td>
        <td>" . select_etat_paiement($infos_peiement_organisateur['etat_paiement']) . "</td>
    </tr>";


for ($i = 0; $i < count($sortie_users); $i++) {
    echo "
    <input type='hidden' value='{$sortie_users[$i]['id']}' name='id_sortie_user'>
    <tr>
        <td>" . $sortie_users[$i]['nom'] . " " . $sortie_users[$i]['prenom'] . "</td>
        <td>" . $sortie_users[$i]['e_mail'] . "</td>
        <td>" . $sortie_users[$i]['no_tel'] . "</td>
        <td>" . select_type_paiement($infos_paiement_users[$i]['type_paiement']) . "</td>
        <td>" . select_date_paiement($infos_paiement_users[$i]['date_paiement']) . "</td>
        <td>" . select_etat_paiement($infos_paiement_users[$i]['etat_paiement']) . "</td>
    </tr>";
        }
        //TODO : changer etat paiement a la sortie

        ?>
    </table>
    <input type="submit" value="enregistrer modifs">
</form>