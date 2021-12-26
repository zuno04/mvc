<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
} else {
    $_SESSION['last_activity'] = time();
    $_SESSION['expire'] = $_SESSION['last_activity'] + (15 * 60);
}

include_once('Models/taches.php');

$addTask_errors = [];
$addTask_correct_data = [];

if(isset($_SESSION['user'])){
    if ($_SESSION['user']['isconnected'] == 'Root' || $_SESSION['user']['isconnected'] == 'Client') {
       
        if(isset($_POST)) {
            
            $newTaskData = json_decode(file_get_contents("php://input"), false);

            if($_SESSION['user']['isconnected'] == 'Root' && $newTaskData->attribuerTache == true) {
                attribuerTache($newTaskData->idTache, $newTaskData->idUser);
            }

            if($newTaskData->createTask == false) {
                
                $updateTask = updateTask($newTaskData->id, $newTaskData->name, $newTaskData->description, $newTaskData->startDate, $newTaskData->endDate);
            } else {
                $emmeteur = $_SESSION['user']['id'];
                $insertionTache = addTask($newTaskData->name, $emmeteur, $newTaskData->description, $newTaskData->startDate, $newTaskData->endDate);
            }

        }
       
    } else {
        if(isset($_POST)) {
            $newTaskData = json_decode(file_get_contents("php://input"), false);

            terminerTache($newTaskData->id);
        }
        // header('Location: index.php?page=dashboard');
    }
} else {
    header('Location: index.php?page=login');
}