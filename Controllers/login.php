<?php

session_start();

include_once('models/user.php');

$login_errors = "";

if(isset($_SESSION['user'])){
    header('Location: index.php?page=dashboard');
} else if(isset($_POST['email']) && isset($_POST['password'])) {
    
    try {
        $user = login($_POST['email'], $_POST['password']);

        if($user) {
            $_SESSION['user'] = $user;
            header('Location: index.php?page=dashboard');
        } else {
            $login_errors = 'Email ou mot de passe incorrecte';
            $_SESSION['login_errors'] = $login_errors;
            header('Location: index.php?page=login');
        }
        
    } catch(Exception $e) {
        echo $e->getMessage();
    }

} else {
    include_once('Views/pages/login.php');
}