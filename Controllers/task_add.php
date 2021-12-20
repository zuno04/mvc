<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once('Models/taches.php');

$addTask_errors = [];
$addTask_correct_data = [];

if(isset($_SESSION['user'])){
    if ($_SESSION['user']['isconnected'] == 'Root') {
       
        if(isset($_POST)) {
            
            $emmeteur = $_SESSION['user']['id'];
            $newTaskData = json_decode(file_get_contents("php://input"), false);
            // var_dump($newTaskData); die;

            $insertionTache = addTask($newTaskData->name, $emmeteur, $newTaskData->description, $newTaskData->startDate, $newTaskData->endDate);
            
            // if(isset($_POST['nom_tache']) && isset($_POST['description_tache']) && isset($_POST['date_debut_tache']) && isset($_POST['date_fin_tache'])) {
            //     $addTask_correct_data['date_debut_tache'] = $_POST['date_debut_tache'];
            //     $addTask_correct_data['date_fin_tache'] = $_POST['date_fin_tache'];

            //     // Validation du Nom de la tache
            //     if(empty(trim($_POST['nom_tache']))) {
            //         $addTask_errors['nom_tache'] = "Ce champ ne peut être vide";
            //     } else {
            //         $addTask_correct_data['nom_tache'] = $_POST['nom_tache'];
            //     }

            //     // Validation de la description de la tache
            //     if(empty(trim($_POST['description_tache']))) {
            //         $addTask_errors['description_tache'] = "Ce champ ne peut être vide";
            //     } else {
            //         $addTask_correct_data['description_tache'] = $_POST['description_tache'];
            //     }

            //     if(!count($addTask_errors)) {
            //         $nomTache = $_POST['nom_tache'];
            //         $emmeteur = $_SESSION['user']['id'];
            //         $descriptionTache = $_POST['description_tache'];
            //         $dateDebutTache = $_POST['date_debut_tache'];
            //         $dateFinTache = $_POST['date_fin_tache'];
                    
            //         $insertionTache = addTask($nomTache, $emmeteur, $descriptionTache, $dateDebutTache, $dateFinTache);
            
            //         if($insertionTache) {
            //             header('Location: index.php?page=dashboard');
            //         } else {
            //             $addTask_errors['ajout_tache'] = "Une erreur est survenue lors de l'ajout de la tâche";
            //             // var_dump($insertionTache); die;
            //             header('Location: index.php?page=task_add');
            //         }
            
            //     } else {
            //         $_SESSION['addTask_errors'] = $addTask_errors;
            //         $_SESSION['addTask_correct_data'] = $addTask_correct_data;
            //         header('Location: index.php?page=task_add');
            //     }
            // }

        } else {
            include_once('Views/pages/task_add.php');
        }
       
    } else {
        header('Location: index.php?page=dashboard');
    }
} else {
    header('Location: index.php?page=login');
}