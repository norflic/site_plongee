<?php

function create_table(){
    $PDO = new PDO('sqlite:C:\Users\nils\Desktop\projets\site_plongee\data/data.db');
    $sql = "create table if not exists inscrits(
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nom varchar,
        prenom varchar,
        mdp varchar,
        date_naissance date,
        ville varchar,
        code_postal numeric,
        nom_rue varchar,
        no_rue numeric,
        pays varchar,
        e_mail varchar,
        date_certif date,
        no_tel varchar,
        chemin_fichier varchar
)";
    $PDO->exec($sql);
}
function insertInto(){
    if (get_user($_POST['nom'], $_POST['prenom'], $_POST['mdp']) != false) {
        exit("l'utilisateur que vous essayez de créer existe déja");
    } else {
        $PDO = new PDO('sqlite:C:\Users\nils\Desktop\projets\site_plongee\data/data.db');
        $sql = "INSERT INTO inscrits (nom, prenom, mdp, date_naissance, ville, code_postal,
                   nom_rue, no_rue, pays, e_mail, date_certif, no_tel, chemin_fichier)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $PDO->prepare($sql);
        $chemin_fichier = get_chemin_fichier();
        $stmt->execute([
            $_POST['nom'],
            $_POST['prenom'],
            password_hash($_POST['mdp'], PASSWORD_DEFAULT),
            $_POST['date_naissance'],
            $_POST['ville'],
            $_POST['code_postal'],
            $_POST['nom_rue'],
            $_POST['no_rue'],
            $_POST['pays'],
            $_POST['e_mail'],
            $_POST['date_certif'],
            $_POST['no_tel'],
            $chemin_fichier
        ]);
//    var_dump($stmt);
    }
}

?>
