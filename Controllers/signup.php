<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$signup_errors = [];
$signup_correct_data = [];

include_once('models/user.php');

if(isset($_SESSION['user'])){
    header('Location: index.php?page=dashboard');
} else if(isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['repassword'])) {
   
    // $signup_correct_data['prenom'] = $_POST['prenom'];
    // $signup_correct_data['nom'] = $_POST['nom'];
    // $signup_correct_data['phone'] = $_POST['phone'];
    
    // Validation du prenom
    if(empty(trim($_POST['prenom']))) {
        $signup_errors['prenom'] = "Ce champ ne peut être vide";
    } else {
        $signup_correct_data['prenom'] = $_POST['prenom'];
    }

    // Validation du nom
    if(empty(trim($_POST['nom']))) {
        $signup_errors['nom'] = "Ce champ ne peut être vide";
    } else {
        $signup_correct_data['nom'] = $_POST['nom'];
    }

    // Validation du numero de telephone
    $phone = trim($_POST['phone']);

    if(preg_match('/((^(\+32|0)\d{3})-?\d{6})/', $phone)) {
        $signup_correct_data['phone'] = $phone;
    } else {
        $signup_errors['phone'] = "Numéro de téléphone invalide";
    }

    // Validation de l'email
    $email = trim($_POST['email']);

    if(!preg_match("/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/", $email)){
        $signup_errors['email'] = "Cet email n'est pas valide";
    } else {
        if(!check_email($_POST['email'])) {
            $signup_correct_data['email'] = $email;
        } else {
            $signup_errors['email'] = "Cet email est déjà utilisé";
        }
    }

    // Validation du mot de passe
    if(strlen($_POST['password']) < 8) {
        $signup_errors['password'] = "Votre mot de passe doit contenir au moins 8 caracteres";
    } 

    if($_POST['repassword'] !== $_POST['password']) {
        $signup_errors['repassword'] = "Les deux mots de passe ne correspondent pas";
    } 

    if(!count($signup_errors)) {
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $insertion = signin($prenom, $nom, $phone, $email, $password);

        if($insertion) {
            $_SESSION['signup_success'] = "Votre compte a été créé avec success, veuillez vous connecter.";
            header('Location: index.php?page=login');
        } else {
            $signup_errors['signup'] = "Une erreur est survenue lors de l'inscription";
        }

    } else {
        $_SESSION['signup_errors'] = $signup_errors;
        $_SESSION['signup_correct_data'] = $signup_correct_data;
        header('Location: index.php?page=signup');
    }
    
} else {
    include_once('Views/pages/signup.php');
}