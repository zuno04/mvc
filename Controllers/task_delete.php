<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once('Models/taches.php');

if(isset($_SESSION['user'])){
    if ($_SESSION['user']['isconnected'] == 'Root') {
       
        if(isset($_POST)) {
            
            $taskObject = json_decode(file_get_contents("php://input"), false);
            // var_dump($taskObject); die;

            $suppressionTache = deleteTask($taskObject->id);

        } else {
            header('Location: index.php?page=dashboard');
        }
       
    } else {
        header('Location: index.php?page=dashboard');
    }
} else {
    header('Location: index.php?page=login');
}