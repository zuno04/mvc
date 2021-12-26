<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} else {
    $_SESSION['last_activity'] = time();
    $_SESSION['expire'] = $_SESSION['last_activity'] + (15 * 60);
}

include_once('Models/user.php');

$signup_errors = [];
$update_success = "";

if(isset($_SESSION['signup_errors'])) {
    $signup_errors = $_SESSION['signup_errors'];
    unset($_SESSION['signup_errors']); 
}

if(isset($_SESSION['update_success'])) {
    $update_success = $_SESSION['update_success'];
    unset($_SESSION['update_success']); 
}

if(isset($_SESSION['user'])){
    // die('<pre>'.print_r($_POST, true).'</pre>');
    
    if(isset($_POST['prenom']) || isset($_POST['nom']) || isset($_POST['phone']) || isset($_POST['password']) || isset($_POST['repassword'])) {
       
        $data_to_update = [];

        // die('<pre>'.print_r($_POST, true).'</pre>');
    
        // Validation du prenom
        if(isset($_POST['prenom'])) {
            if(empty(trim($_POST['prenom']))) {
                $signup_errors['prenom'] = "Le prénom ne peut être vide";
            } else {
                $data_to_update['first_name'] = $_POST['prenom'];
            }
        }
    
        // Validation du nom
        if(isset($_POST['nom'])) {
            if(empty(trim($_POST['nom']))) {
                $signup_errors['nom'] = "Le nom ne peut être vide";
            } else {
                $data_to_update['last_name'] = $_POST['nom'];
            }
        }
    
        // Validation du numero de telephone
        if(isset($_POST['phone'])) {
            if(empty(trim($_POST['phone']))) {
                $signup_errors['phone'] = "Le numéro de téléphone ne peut être vide";
            } else {
                $phone = trim($_POST['phone']);
                
                if(preg_match('/^\+\d+$/', $phone)) {
                    $data_to_update['phone'] = $phone;
                } else {
                    $signup_errors['phone'] = "Numéro de téléphone invalide";
                }
            }
        }
    
    
        // Validation du mot de passe
        if(isset($_POST['password'])) {
            if(strlen($_POST['password']) < 8) {
                $signup_errors['password'] = "Votre mot de passe doit contenir au moins 8 caractères";
            } else {
                $data_to_update['password'] = $_POST['password'];
            }     
        } 
    
        if(isset($_POST['repassword'])) {
            if ($_POST['repassword'] !== $_POST['password']) {
                $signup_errors['repassword'] = "Les deux mots de passe ne correspondent pas";
            }
        }
    
        if(!count($signup_errors)) {
            
            $update = updateUserSettings($_SESSION['user']['id'], $data_to_update);
    
            if($update) {
                $_SESSION['update_success'] = "Votre compte a été mis à jour." .  PHP_EOL . "Les changement prendront effets".  PHP_EOL . "après votre prochaine connexion";
                // die($_SESSION['update_success']);
            } else {
                $signup_errors['signup'] = "Une erreur est survenue lors de la mise à jour de votre compte";
            }

            header('Location: index.php?page=settings');
    
        } else {
            $_SESSION['signup_errors'] = $signup_errors;
            $_SESSION['signup_correct_data'] = $signup_correct_data;
            header('Location: index.php?page=settings');
        }
    } else {
        include_once('Views/pages/settings.php');
    }

} else {
    header('Location: index.php?page=login');
}


