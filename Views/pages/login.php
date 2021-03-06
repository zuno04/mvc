<?php 
// session_start();
include_once(__DIR__ . '/../partials/header.php'); 
?>

    <main class='container main-container d-flex justify-content-center'>
        <form method="POST" action="index.php?page=login">
            <!-- Login Errors display -->
            <?php if(isset($_SESSION['login_errors']) && strlen($_SESSION['login_errors']) > 0): ?>
            <div class="p-4 mb-4 border jumbotron h-15 bg-light rounded-3 text-danger">
               <?= $_SESSION['login_errors'] ?>
            </div>
            <?php endif; ?>
            
            <!-- Signin sucess display -->
            <?php if(isset($_SESSION['signup_success']) && strlen($_SESSION['signup_success']) > 0): ?>
            <div class="alert alert-success alert-dismissible text-wrap">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Bravo!</strong> <?= $_SESSION['signup_success'] ?>
            </div>
            <?php endif; ?>

            <h1 class="mb-3 h3 fw-normal">Veuillez vous connecter</h1>

            <div class="form-floating">
                <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                <label for="floatingInput">Email</label>
            </div>

            <!-- <small id="passwordHelp" class="text-danger">
                Must be 8-20 characters long.
            </small> -->

            <div class="mt-3 form-floating">
                <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                <label for="floatingPassword">Mot de passe</label>
            </div>

            <!-- Connecter en tant que -->
            <div  class="mt-3">
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="connected_as"
                        id="user_client_id"
                        value="Client"
                    />
                    <label class="form-check-label" for="user_client_id">Client</label>
                </div>

                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="connected_as"
                        id="user_employee_id"
                        value="Travailleur"
                        checked
                    />
                    <label class="form-check-label" for="user_employee_id">Travailleur</label>
                </div>

                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="connected_as"
                        id="user_root_id"
                        value="Root"
                    />
                    <label class="form-check-label" for="user_root_id">Root</label>
                </div>
            </div>
            <button class="mt-3 w-100 btn btn-lg btn-primary" type="submit">Se connecter</button>
            <p class="mt-3">Pas encore inscrit ? <a href="index.php?page=signup" class="text-decoration-none">Cr??ez votre compte</a></p>
        </form>
    </main>

  <?php include_once(__DIR__ . '/../partials/footer.php'); ?>