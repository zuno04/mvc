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
            E.id 'id_executant',
            E.first_name 'prenom_executant',
            E.last_name 'nom_executant',
            U.id 'id_auteur',
            U.first_name 'prenom_auteur',
            U.last_name 'nom_auteur'

            FROM tache T
            LEFT JOIN user U ON T.commanditaire=U.id
            LEFT JOIN user E ON T.id_utilisateur=E.id
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

// Terminer une tache (Mise a jour de l'etat)
function terminerTache($id_tache) {
    $bdd = Database::getInstance(); 
    // var_dump( $nomTache); die;

    try {
        $req = $bdd->connection->prepare("UPDATE tache SET etat = 'Terminee' WHERE id = :id");   
        $req->bindParam(':id', $id_tache, PDO::PARAM_STR);  
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

// Mettre a jour une tache
function updateTask($id_tache, $nomTache, $descriptionTache, $dateDebutTache, $dateFinTache) {
    $bdd = Database::getInstance(); 
    // var_dump( $nomTache); die;

    try {
        $req = $bdd->connection->prepare("UPDATE tache SET name = :name, description = :description, date_debut = :date_debut, date_fin = :date_fin WHERE id = :id"); 
        $req->bindParam(':name', $nomTache, PDO::PARAM_STR);  
        $req->bindParam(':description', $descriptionTache, PDO::PARAM_STR);  
        $req->bindParam(':date_debut', $dateDebutTache, PDO::PARAM_STR);  
        $req->bindParam(':date_fin', $dateFinTache, PDO::PARAM_STR);  
        $req->bindParam(':id', $id_tache, PDO::PARAM_STR);  
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

// Supprimer une tache
function deleteTask($task_id) {
    $bdd = Database::getInstance(); 

    $id = isset($task_id) ? $task_id : null;

    try {
        $req = $bdd->connection->prepare("DELETE FROM tache WHERE id = :id"); 
        $req->bindParam(':id', $id, PDO::PARAM_STR); 
        $req->execute();

        return true;
    } catch(Exception $e) {
        die('Erreur : '.$e->getMessage());
    }
}