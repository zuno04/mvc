<?php 

// Verification de l'email
function check_email($email) {
    global  $bdd; 

    try {
        $req = $bdd->prepare("SELECT * FROM user WHERE email = :email"); 
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
    global  $bdd; 

    $_email = isset($email) ? $email : null;
    //$hash = password_hash($password, PASSWORD_BCRYPT);
    $_password = isset($password) ? $password : null;

    try {
        $req = $bdd->prepare("SELECT * FROM user WHERE email = :email"); 
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
    global  $bdd; 

    $mot_de_passe_crypte = password_hash($password, PASSWORD_BCRYPT);
    $isConnected = "Disconnected";
    $status = 'a:1:{i:0;s:7:"ouvirer";}';

    try {
        $req = $bdd->prepare("INSERT INTO user (last_name, first_name, email, phone, password, isconnected, statuts, activated) VALUES (:nom, :prenom, :email, :phone, :password, :isconnected, :status, 0)"); 
        $req->bindParam(':nom', $nom, PDO::PARAM_STR); 
        $req->bindParam(':prenom', $prenom, PDO::PARAM_STR); 
        $req->bindParam(':email', $email, PDO::PARAM_STR); 
        $req->bindParam(':phone', $phone, PDO::PARAM_STR); 
        $req->bindParam(':password', $mot_de_passe_crypte, PDO::PARAM_STR); 
        $req->bindParam(':isconnected', $isConnected, PDO::PARAM_STR); 
        $req->bindParam(':status', $status, PDO::PARAM_STR); 

        $bdd->beginTransaction();

        $req->execute();

        $bdd->commit();

        $last_id = $bdd->lastInsertId();
        
        die($last_id);

        // if(!empty($user) && password_verify($_password, $user['password'])) {

        //     return $user;
        // } 
        // else {
        //     return null;
        // }
    } catch(Exception $e) {
        $bdd->rollback();
        print "Error!: " . $e->getMessage() . "</br>";
    }    
    
}