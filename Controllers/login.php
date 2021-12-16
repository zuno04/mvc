<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once('Models/user.php');

$login_errors = "";

if(isset($_SESSION['user'])){
    header('Location: index.php?page=dashboard');
} else if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['connected_as'])) {
    
    try {
        $login_request = login($_POST['email'], $_POST['password'], $_POST['connected_as']);

        if($login_request->success) {
            $_SESSION['user'] = $login_request->data;
            header('Location: index.php?page=dashboard');
        } else {
            $login_errors = $login_request->message;
            $_SESSION['login_errors'] = $login_errors;
            header('Location: index.php?page=login');
        }
        
    } catch(Exception $e) {
        echo $e->getMessage();
    }

} else {
    include_once('Views/pages/login.php');
}