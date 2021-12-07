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
function login($email, $password) { 
    $bdd = Database::getInstance(); 

    $_email = isset($email) ? $email : null;
    //$hash = password_hash($password, PASSWORD_BCRYPT);
    $_password = isset($password) ? $password : null;

    try {
        $req = $bdd->connection->prepare("SELECT * FROM user WHERE email = :email"); 
        $req->bindParam(':email', $_email, PDO::PARAM_STR); 
        $req->execute();

        $user = $req->fetch(); 

        if(!empty($user) && password_verify($_password, $user['password'])) {

            return $user;
        } 
        else {
            return null;
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
    $status = 'a:1:{i:0;s:7:"ouvirer";}';

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
        
        // var_dump($last_id); die;

        return $last_id;

    } catch(Exception $e) {
        $bdd->connection->rollback();
        print "Error!: " . $e->getMessage() . "</br>";
    }    
    
}