<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// echo $_SERVER['SERVER_NAME'] . "\n";

// var_dump($_SERVER ["REQUEST_URI"]);die;

include_once('Models/taches.php');
include_once('Models/user.php');

if(isset($_SESSION['user'])){
    $taches = getTasks();
    $travailleurs =  getUsers();
    include_once('Views/pages/dashboard.php');
} else {
    header('Location: index.php?page=login');
}


