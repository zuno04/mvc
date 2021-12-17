<?php 

// Recuperer toutes les taches
function getTasks() {
    $bdd = Database::getInstance();

    try {
        $req = $bdd->connection->prepare("
            SELECT 
            T.id, 
            T.name, 
            T.description, 
            T.date_debut, 
            T.date_fin,
            T.etat,
            T.commanditaire,
            T.id_utilisateur ,
            U.id 'id_auteur',
            U.first_name 'prenom_auteur',
            U.last_name 'nom_auteur'

            FROM tache T
            LEFT JOIN user U ON T.commanditaire=U.id
        "); 
        $req->execute();
        $tasks = $req->fetchAll(); 

        // var_dump($tasks); die;

        return $tasks;

    } catch(Exception $e) {
        die('Erreur : '.$e->getMessage());
    }
}

// Recuperer une tache via son id
function getTaskById($task_id) {
    $bdd = Database::getInstance(); 

    $id = isset($task_id) ? $task_id : null;

    try {
        $req = $bdd->connection->prepare("SELECT * FROM tache WHERE id = :id"); 
        $req->bindParam(':id', $id, PDO::PARAM_STR); 
        $req->execute();

        $user = $req->fetch(); 

        if(!empty($user)) {

            return $user;
        } 
        else {
            return null;
        }
    } catch(Exception $e) {
        die('Erreur : '.$e->getMessage());
    }
}

// Ajouter une tache
function addTask($nomTache, $emmeteur, $descriptionTache, $dateDebutTache, $dateFinTache) {
    $bdd = Database::getInstance(); 
    $etat_tache = 'EnCours';
    $emmeteur = intval($emmeteur);
    // $id_utilisateur = null;

    try {
        $bdd->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES,TRUE);
        $req = $bdd->connection->prepare("INSERT INTO tache (name, description, date_debut, date_fin, etat, commanditaire, id_utilisateur) VALUES (:nom_tache, :description_tache, :date_debut_tache, :date_fin_tache, :etat_tache, :emmeteur, NULL)"); 
        $req->bindParam(':nom_tache', $nomTache, PDO::PARAM_STR); 
        $req->bindParam(':description_tache', $descriptionTache, PDO::PARAM_STR); 
        $req->bindParam(':date_debut_tache', $dateDebutTache, PDO::PARAM_STR); 
        $req->bindParam(':date_fin_tache', $dateFinTache, PDO::PARAM_STR); 
        $req->bindParam(':etat_tache', $etat_tache, PDO::PARAM_STR); 
        $req->bindParam(':emmeteur', $emmeteur, PDO::PARAM_INT); 

        $bdd->connection->beginTransaction();

        $req->execute();

        $last_id = $bdd->connection->lastInsertId();

        $bdd->connection->commit();

        return $last_id;
    } catch(Exception $e) {
        die('Erreur : '.$e->getMessage());
    }
}

// Mettre a jour le statut de l'utilisateur
function updateUserStatus($user_id, $statuts) {
    $bdd = Database::getInstance(); 

    $id = isset($user_id) ? $user_id : null;
    $statuts = isset($statuts) ? $statuts : null;

    // var_dump($statuts); die;

    try {
        $req = $bdd->connection->prepare("UPDATE user SET statuts = :statuts WHERE id = :id"); 
        $req->bindParam(':id', $id, PDO::PARAM_STR); 
        $req->bindParam(':statuts', $statuts, PDO::PARAM_STR); 
        $update_successfull = $req->execute();

        if($update_successfull){
            return true;
        } else {
            return false;
        }
    } catch(Exception $e) {
        die('Erreur : '.$e->getMessage());
    }
}

// Modifier l'attribute isconnected de l'utilisateur en BD apres la deconnexion il prendra la valeur 'Disconnected'
function disconnect($user_id) {
    $bdd = Database::getInstance();

    $_is_connected = "Disconnected";

    try {
        $req_update = $bdd->connection->prepare("UPDATE user SET isconnected = :isconnected WHERE id = :id"); 
        $req_update->bindParam(':id', $user_id, PDO::PARAM_INT); 
        $req_update->bindParam(':isconnected', $_is_connected, PDO::PARAM_STR); 
        $update_successfull =  $req_update->execute();

        // On retourne l'etat de l'operation de mise a jour : true ou false
        return  $update_successfull;
    } catch(Exception $e) {
        die('Erreur : '.$e->getMessage());
    }
}