<?php
session_start();

include_once('models/user.php');

if(isset($_SESSION['user'])){
    header('Location: index.php?page=dashboard');
} else if(isset($_POST['email']) && isset($_POST['password'])) {
    $user = login('emaga87@gmail.com', '123456789');
    $_SESSION['user'] = $user;
    // var_dump($user);die;
    header('Location: index.php?page=dashboard');
} else {
    include_once('Views/pages/login.php');
}


