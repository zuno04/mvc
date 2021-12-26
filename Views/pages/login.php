<?php 
// session_start();
include_once(__DIR__ . '/../partials/header.php'); 
?>

    <main class='main-content container main-container d-flex justify-content-center'>
        <form method="POST" action="index.php?page=login">
            <!-- Login Errors display -->
            <?php if(isset($login_errors) && !empty($login_errors)): ?>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div class="max-width-fit-content">
                    <?= $login_errors ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Signin sucess display -->
            <?php if(isset($signup_success) && !empty($signup_success)): ?>
            <div class="alert alert-success alert-dismissible max-width-fit-content">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Bravo!</strong> <?= $signup_success ?>
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
            <p class="mt-3">Pas encore inscrit ? <a href="index.php?page=signup" class="text-decoration-none">Créez votre compte</a></p>
        </form>
    </main>

  <?php include_once(__DIR__ . '/../partials/footer.php'); ?>