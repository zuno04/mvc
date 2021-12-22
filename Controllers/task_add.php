<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once('Models/taches.php');

$addTask_errors = [];
$addTask_correct_data = [];

if(isset($_SESSION['user'])){
    if ($_SESSION['user']['isconnected'] == 'Root' || $_SESSION['user']['isconnected'] == 'Client') {
       
        if(isset($_POST)) {
            
            $newTaskData = json_decode(file_get_contents("php://input"), false);

            if($newTaskData->createTask == false) {
                
                $updateTask = updateTask($newTaskData->id, $newTaskData->name, $newTaskData->description, $newTaskData->startDate, $newTaskData->endDate);
            } else {
                $emmeteur = $_SESSION['user']['id'];
                $insertionTache = addTask($newTaskData->name, $emmeteur, $newTaskData->description, $newTaskData->startDate, $newTaskData->endDate);
            }

        }
       
    } else {
        die("DDDD");
        if(isset($_POST)) {
            $newTaskData = json_decode(file_get_contents("php://input"), false);

            var_dump($newTaskData); die;
        }
        // header('Location: index.php?page=dashboard');
    }
} else {
    header('Location: index.php?page=login');
}