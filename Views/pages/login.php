<?php 
session_start();
include_once(__DIR__ . '/../partials/header.php'); 
?>

    <main class='container main-container d-flex justify-content-center'>
        <form method="POST" action="index.php?page=login">
            <?php if(isset($_SESSION['login_errors']) && strlen($_SESSION['login_errors']) > 0): ?>
            <div class="jumbotron h-15 p-4 bg-light border rounded-3 mb-4 text-danger">
               <?= $_SESSION['login_errors'] ?>
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

            <div class="form-floating mt-3">
                <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                <label for="floatingPassword">Mot de passe</label>
            </div>

            <!-- <div class="mb-3 mt-3 checkbox row">
                <div class="col-sm-3">
                    <label>
                        <input name="remember-me" type="checkbox" value="remember-me"> Rester connecté
                    </label>
                </div>
            </div> -->
            <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Se connecter</button>
            <p class="mt-3">Pas encore inscrit ? <a href="index.php?page=signup" class="text-decoration-none">Créez votre compte</a></p>
        </form>
    </main>

  <?php include_once(__DIR__ . '/../partials/footer.php'); ?>