<?php 

// Verification de l'email
function check_email($email) {
    $bdd = Database::getInstance();

    try {
        $req = $bdd->connection->prepare("SELECT * FROM user WHERE email = :email"); 
        $req->bindParam(':email', $email, PDO::PARAM_STR); 
        $req->execute();

        $email_exists = $req->fetch(); 

        if(!empty($email_exists)) {

            return true;
        } 
        else {
            return false;
        }
    } catch(Exception $e) {
        die('Erreur : '.$e->getMessage());
    }    
}

// Connexion d'un utilisateur
function login($email, $password, $connected_as) { 
    $bdd = Database::getInstance(); 

    $_email = isset($email) ? $email : null;
    //$hash = password_hash($password, PASSWORD_BCRYPT);
    $_password = isset($password) ? $password : null;
    $_connected_as = isset($connected_as) ? $connected_as : 'Client';

    // On cree un objet pour stocker les erreurs
    $request_result = new stdClass();

    try {
        $req = $bdd->connection->prepare("SELECT * FROM user WHERE email = :email");  
        $req->bindParam(':email', $_email, PDO::PARAM_STR);
        $req->execute();

        $user = $req->fetch(); 

        if(!empty($user) && password_verify($_password, $user['password'])) {

            if($user['isconnected'] !== "Disconnected") {
                $request_result->success = false;
                $request_result->message = 'Vous avez déjà été ouvert une session !';
                return $request_result;
            } else if (in_array($_connected_as, unserialize($user['statuts']))) { // On verifie si le statut avec lequel l'utilisateur se connecte est bien parmis ceux qu'il possede en BD
                
                // Changer la valeur de isconnected en BD elle prendra la valeur de la variable $_connected_as
                try {
                    $req_update = $bdd->connection->prepare("UPDATE user SET isconnected = :isconnected WHERE id = :id"); 
                    $req_update->bindParam(':id', $user['id'], PDO::PARAM_INT); 
                    $req_update->bindParam(':isconnected', $_connected_as, PDO::PARAM_STR); 
                    $update_successfull =  $req_update->execute();

                    // On retourne l'utilisateur si la mise a jour a fonctionne
                    if($update_successfull){

                        $user['isconnected'] = $_connected_as;

                        $request_result->success = true;
                        $request_result->data = $user;
                        return $request_result;
                    } else {
                        $request_result->success = false;
                        $request_result->message = 'La mise à jour du statut de l\'utilisateur a échoué';
                        return $request_result;
                    }
                } catch(Exception $e) {
                    die('Erreur : '.$e->getMessage());
                }

            } else {
                $request_result->success = false;
                $request_result->message = 'Le statut est incorrect !';
                return $request_result;
            }
        } 
        else {
            $request_result->success = false;
            $request_result->message = 'Email ou mot de passe incorrect !';
            return $request_result;
        }
    } catch(Exception $e) {
        die('Erreur : '.$e->getMessage());
    }    
    
}


// Creation du compte d'un utilisateur
function signin($prenom, $nom, $phone, $email, $password) { 
    $bdd = Database::getInstance();

    $mot_de_passe_crypte = password_hash($password, PASSWORD_BCRYPT);
    $isConnected = "Disconnected";
    $status = 'a:1:{i:0;s:11:"Travailleur";}';

    try {
        $bdd->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES,TRUE);
        $req = $bdd->connection->prepare("INSERT INTO user (last_name, first_name, email, phone, password, isconnected, statuts, activated) VALUES (:nom, :prenom, :email, :phone, :password, :isconnected, :status, 0)"); 
        $req->bindParam(':nom', $nom, PDO::PARAM_STR); 
        $req->bindParam(':prenom', $prenom, PDO::PARAM_STR); 
        $req->bindParam(':email', $email, PDO::PARAM_STR); 
        $req->bindParam(':phone', $phone, PDO::PARAM_STR); 
        $req->bindParam(':password', $mot_de_passe_crypte, PDO::PARAM_STR); 
        $req->bindParam(':isconnected', $isConnected, PDO::PARAM_STR); 
        $req->bindParam(':status', $status, PDO::PARAM_STR); 

        $bdd->connection->beginTransaction();

        $req->execute();

        $last_id = $bdd->connection->lastInsertId();

        $bdd->connection->commit();

        return $last_id;

    } catch(Exception $e) {
        $bdd->connection->rollback();
        print "Error!: " . $e->getMessage() . "</br>";
    }    
    
}


// Recuperer tous les utilisateurs
function getUsers() {
    $bdd = Database::getInstance();

    try {
        $req = $bdd->connection->prepare("SELECT * FROM user"); 
        $req->execute();
        $users = $req->fetchAll(); 

        return $users;

    } catch(Exception $e) {
        die('Erreur : '.$e->getMessage());
    }
}

// Recuperer un utilisateur via son id
function getUserById($user_id) {
    $bdd = Database::getInstance(); 

    $id = isset($user_id) ? $user_id : null;

    try {
        $req = $bdd->connection->prepare("SELECT * FROM user WHERE id = :id"); 
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