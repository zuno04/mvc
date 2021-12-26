<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once('Models/user.php');

$login_errors = "";
$signup_success = "";

if(isset($_SESSION['signup_success'])) {
    $signup_success = $_SESSION['signup_success'];
    unset($_SESSION['signup_success']); 
}

if(isset($_SESSION['login_errors'])) {
    $login_errors = $_SESSION['login_errors'];
    unset($_SESSION['login_errors']); 
}

if(isset($_SESSION['user'])){
    header('Location: index.php?page=dashboard');
} else if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['connected_as'])) {
    
    try {
        $login_request = login($_POST['email'], $_POST['password'], $_POST['connected_as']);

        if($login_request->success) {
            $_SESSION['user'] = $login_request->data;
            
            $_SESSION['start'] = time(); // Prendre le temps de connexion

            // Définir la durée de la session
            $_SESSION['expire'] = $_SESSION['start'] + (15 * 60); 
            header('Location: index.php?page=dashboard');
        } else {
            $_SESSION['login_errors'] = $login_request->message;
            header('Location: index.php?page=login');
        }
        
    } catch(Exception $e) {
        echo $e->getMessage();
    }

} else {
    include_once('Views/pages/login.php');
}