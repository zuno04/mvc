<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once('Models/taches.php');

$taskAdd_errors = "";

if(isset($_SESSION['user'])){
    if ($_SESSION['user']['isconnected'] == 'Root') {
       
    
        if(isset($_POST['taskName']) && isset($_POST['taskType']) && isset($_POST['taskDescription']) && isset($_POST['taskDateDebut']) && isset($_POST['taskDateFin'])) {
            var_dump($_POST); die;
        } else {
            include_once('Views/pages/task_add.php');
        }
       
    } else {
        header('Location: index.php?page=dashboard');
    }
} else {
    header('Location: index.php?page=login');
}