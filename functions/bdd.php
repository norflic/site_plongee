<?php
// TODO : créer un htaccess pour proteger la BD
function create_table_users(){
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
function create_table_sorties(){
    $PDO = new PDO('sqlite:../data/data.db');
    $sql = "create table if not exists sorties(
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nom VARCHAR,
        nb_participants INTEGER,
        prix DECIMAL(10,2),
        lieu VARCHAR,
        description TEXT,
        organisateur VARCHAR
)";
    $PDO->exec($sql);
}

function create_table_sortie_users(){
    $PDO = new PDO('sqlite:../data/data.db');
    $sql = "create table if not exists sortie_users(
        id_user INTEGER,
        id_sortie INTEGER,
        nb_combis INTEGER DEFAULT 0,
        type_combi TEXT,
        nb_stabes INTEGER DEFAULT 0,
        type_stabe TEXT,
        nb_blocs INTEGER DEFAULT 0,
        type_bloc TEXT,
        nb_detendeurs INTEGER DEFAULT 0,
        type_detendeur TEXT,
        PRIMARY KEY (id_user, id_sortie)
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
    $PDO = new PDO('sqlite:../data/data.db');
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

/**
 * utilise les variables de sessions pour récupérer l'utilisateur
 * @return false|mixed
 */
function get_myself(){
    var_dump("SESSION = ");
    var_dump($_SESSION);
    return get_user($_SESSION['nom'], $_SESSION['prenom'], $_SESSION['mdp']);
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
        $sql = "INSERT INTO sorties (nom, nb_participants, prix, lieu, description, organisateur)
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
//    var_dump($stmt);
}
function get_sorties(){
    //    var_dump($nom, $prenom, $mdp);
    $PDO = new PDO('sqlite:../data/data.db');
    $stmt = $PDO->prepare("select * from sorties");
    $stmt->execute();
    $sortie = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($sortie) == 0)
        return false;
    else {
//    var_dump($sortie);
        return $sortie;
    }
}
function get_sortie($id_sortie){
    //    var_dump($nom, $prenom, $mdp);
    $PDO = new PDO('sqlite:../data/data.db');
    $stmt = $PDO->prepare("select * from sorties where id = ?");
    $stmt->execute([$id_sortie]
    );
    $sortie = $stmt->fetch(PDO::FETCH_ASSOC);
//        var_dump($sortie);
        return $sortie;
}

function inscription_sortie($id_user, $id_sortie): void
{
    try {
        $PDO = new PDO('sqlite:../data/data.db');
        $sql = "INSERT INTO sortie_users (id_user, id_sortie)
            VALUES (?,?)";
        $stmt = $PDO->prepare($sql);
        $stmt->execute([
            $id_user,
            $id_sortie,
        ]);
//    var_dump($stmt);
    } catch (PDOException $e) {
        ?>
        <div>
            <strong>Une erreur s'est produite</strong>
            <p> Vous etes deja isncrit</p>
            <details>
                <summary>Details</summary>
                id_user=<?= $id_user ?>, id_sortie=<?= $id_sortie ?>
                <?= $e->getMessage(); ?>
            </details>
        </div>
    <?php
    }
}
function ajoute_materiel($id_user, $id_sortie, $materiel, $type, $nb_materiel){
    $PDO = new PDO('sqlite:../data/data.db');
    if ($materiel == "combi") {
        $sql = "UPDATE sortie_users SET type_combi = :type_materiel, nb_combis = :nb_materiel WHERE id_user = :id_user AND id_sortie = :id_sortie";
    } elseif ($materiel == "stabe") {
        $sql = "UPDATE sortie_users SET type_stabe = :type_materiel, nb_stabes = :nb_materiel WHERE id_user = :id_user AND id_sortie = :id_sortie";
    } elseif ($materiel == "bloc") {
        $sql = "UPDATE sortie_users SET type_bloc = :type_materiel, nb_blocs = :nb_materiel WHERE id_user = :id_user AND id_sortie = :id_sortie";
    } elseif ($materiel == "detendeur") {
        $sql = "UPDATE sortie_users SET type_detendeur = :type_materiel, nb_detendeurs = :nb_materiel WHERE id_user = :id_user AND id_sortie = :id_sortie";
    } else {
        throw new Exception("ce type de materiel n'existe pas : ".$materiel." meteriels autorises : combi, stabe, bloc, detendeur");
    }
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':type_materiel', $type);
    $stmt->bindParam(':nb_materiel', $nb_materiel);
    $stmt->bindParam(':id_user', $id_user);
    $stmt->bindParam(':id_sortie', $id_sortie);

    $stmt->execute();
//    var_dump($stmt);
}

?>


