<?php 
function login($email, $password) { 
    global  $bdd; 

    $_email = isset($email) ? $email : null;
    //$hash = password_hash($password, PASSWORD_BCRYPT);
    $_password = isset($password) ? $password : null;

    //echo password_hash($password, PASSWORD_BCRYPT); die;
    //echo $_password; die;
    //die($password);

    

    $req = $bdd->prepare("SELECT * FROM user WHERE email = :email"); 
    $req->bindParam(':email', $_email, PDO::PARAM_STR); 
    $req->execute();

    $user = $req->fetch(); 

    //die($user['password']);
    //var_dump(password_verify($_password, $user['password'])); die;

    if(!empty($user) && password_verify($_password, $user['password'])) {

        return $user;
    } 

    return [];
    
}