<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once('Models/taches.php');

if(isset($_SESSION['user'])){
    $taches = getTasks();
    include_once('Views/pages/dashboard.php');
} else {
    header('Location: index.php?page=login');
}


