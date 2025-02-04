<?php
// TODO : créer un htaccess pour proteger la BD
function create_table(){
    $PDO = new PDO('sqlite:../data/data.db');
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

/**
 * renvoie le premier user qui correspond
 * renvoie false si il n'existe pas
 * necessite un mot de pass non haché
 * @param string $nom
 * @param string $prenom
 * @param string $mdp
 * @param bool $estHaché
 * @return false|mixed
 */
function get_user(string $nom, string $prenom, string $mdp){
//    var_dump($nom, $prenom, $mdp);
    $PDO = new PDO('sqlite:C:\Users\nils\Desktop\projets\site_plongee\data/data.db');
    $stmt = $PDO->prepare("select * from inscrits where nom = ? and prenom = ?");
    $stmt->execute([$nom, $prenom]);
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
    for ($i = 0; $i < count($user); $i++) {
        if (password_verify($mdp, $user[$i]['mdp'])) {
            return $user[$i];
        }
    }
//    var_dump($user);
    return false;
}


function insertInto(){
    if (get_user($_POST['nom'], $_POST['prenom'], $_POST['mdp']) != false) {
        exit("l'utilisateur que vous essayez de créer existe déja");
    } else {
        $PDO = new PDO('sqlite:../data/data.db');
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

/**
 * cree une sortie
 * @param $nom
 * @param $nb_participants
 * @param $prix
 * @param $lieu
 * @param $description
 * @param $organisateur
 * @return void
 */
function cree_sortie($nom, $nb_participants, $prix, $lieu, $description, $organisateur){
        $PDO = new PDO('sqlite:../data/data.db');
        $sql = "INSERT INTO inscrits (nom, nb_participants, prix, lieu, description, organisateur)
            VALUES (?,?,?,?,?,?)";
        $stmt = $PDO->prepare($sql);
        $stmt->execute([
            $nom,
            $nb_participants,
            $prix,
            $lieu,
            $description,
            $organisateur,
        ]);
    var_dump($stmt);
}

?>


