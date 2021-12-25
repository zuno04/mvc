<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once('Models/user.php');

if(isset($_SESSION['user'])){
    if ( $_SESSION['user']['isconnected'] == 'Root') {
        if(isset($_GET['user_id'])) {
            if(isset($_POST['status_updated'])) {
                // Mettre a jour le statut de l'utilisateur
                $user_status = [];

                if(isset($_POST['statut_root'])) {
                    array_push($user_status, "Root");
                }
                
                if(isset($_POST['statut_travailleur'])) {
                    array_push($user_status, "Travailleur");
                }
                
                if(isset($_POST['statut_client'])) {
                    array_push($user_status, "Client");
                }
               
                // Serialiser le statut
                $mise_a_jour_reussie = $user_status = serialize($user_status);

                // Mettre a jour le statut de l'utilisateur
                updateUserStatus($_GET['user_id'], $user_status);

                // Retourner a la page de gestion des utilisateurs
                header('Location: index.php?page=manage_users');
            } else {
                $user = getUserById($_GET['user_id']);
                if($user) {
                    include_once('Views/pages/user_edit.php');
                } else {
                    header('Location: index.php?page=manage_users');
                }
            }
        } else if(isset($_POST)) {
            $userActivation = json_decode(file_get_contents("php://input"), false);

            // var_dump($userActivation); die;

            userActivation($userActivation->id, $userActivation->isChecked);
        } else {
            header('Location: index.php?page=manage_users');
        }
    } else {
        header('Location: index.php?page=dashboard');
    }
} else {
    header('Location: index.php?page=login');
}

