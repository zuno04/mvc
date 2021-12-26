<?php 
  //session_start();
  include_once(__DIR__ . '/../partials/header.php'); 

?>

    <main id="main" class='main-content mb-5 container d-flex justify-content-center main-container'>
        <form method="POST" action="index.php?page=settings">
            <h1 class="mb-2 h3 fw-normal">Mon compte</h1>
            <h1 class="mb-5 h6 fw-normal fst-italic">(Double cliquer dans le champ pour modifier)</h1>

            <!--Message succes de mise a jour -->
            <?php if(isset($update_success) && !empty($update_success)): ?>
            <div class="alert alert-success alert-dismissible fade show max-width-fit-content" role="alert">
                <strong>Félicitations!</strong> <?= $update_success ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <!-- Prenom et Nom -->
            <div class="row">
                <div ondblclick="editElement(this, 'prenom')" class="col-md-6">
                    <div class="form-floating input-group has-validation">
                        <input name="prenom" type="text" class="cursor-pointer form-control<?= isset($signup_errors['prenom']) ? " border-danger" : "" ?>" id="prenom" placeholder="Prénom" required value=<?= $_SESSION['user']['first_name'] ?> disabled>
                        <label for="prenom">Prénom</label>
                    </div>
                    <?php if(isset($signup_errors['prenom'])): ?>
                    <small id="passwordHelp" class="mt-2 text-danger">
                        <sapn class="max-width-fit-content"><?= $signup_errors['prenom'] ?></sapn>
                    </small>
                    <?php endif; ?>
                </div>
    
                <div class="col-md-6">
                    <div ondblclick="editElement(this, 'nom')" class="form-floating">
                        <input required name="nom" type="text" class="cursor-pointer form-control<?= isset($signup_errors['nom']) ? " border-danger" : "" ?>" id="nom" placeholder="Nom" required value=<?= $_SESSION['user']['last_name'] ?> disabled>
                        <label for="nom">Nom</label>
                    </div>
                    <?php if(isset($signup_errors['nom'])): ?>
                    <small id="passwordHelp" class="mt-2 text-danger">
                        <sapn class="max-width-fit-content"><?= $signup_errors['nom'] ?></sapn>
                    </small>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Telephone -->
            <div ondblclick="editElement(this, 'phone')" class="mt-3 form-floating">
                <input required name="phone" type="text" class="cursor-pointer form-control<?= isset($signup_errors['phone']) ? " border-danger" : "" ?>" id="phone" placeholder="Telephone" value=<?= $_SESSION['user']['phone'] ?> disabled>
                <label for="phone">Telephone</label>
            </div>
            <?php if(isset($signup_errors['phone'])): ?>
            <small id="passwordHelp" class="mt-2 text-danger">
                <span class="max-width-fit-content"><?= $signup_errors['phone'] ?></span>
            </small>
            <?php endif; ?>

            <!-- Email -->
            <div class="mt-3 form-floating">
                <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com" value=<?= $_SESSION['user']['email'] ?> disabled>
                <label for="floatingInput">Email</label>
            </div>

            <!-- Mot de passe -->
            <div  class="mt-3">
               <span class="fw-bold">Modifier le mot de passe</span>
            </div>

            <div class="row">
                <div class="col-md-6" ondblclick="editElement(this, 'floatingPassword', 'refloatingPassword')">
                    <div class="mt-3 form-floating">
                        <input disabled name="password" type="password" class="cursor-pointer form-control" id="floatingPassword" required>
                        <label for="floatingPassword">Nouveau mot de passe</label>
                    </div>

                    <?php if(isset($signup_errors['password'])): ?>
                    <div class="text-danger max-width-fit-content"><p><?= $signup_errors['password'] ?></p></div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <div class="mt-3 form-floating">
                        <input disabled name="repassword" type="password" class="cursor-pointer form-control" id="refloatingPassword" required>
                        <label for="refloatingPassword">Repeter le mot de passe</label>
                    </div>
                    <?php if(isset($signup_errors['repassword'])): ?>
                    <div class="text-danger max-width-fit-content"><p><?= $signup_errors['repassword'] ?></p></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Type de compte -->
            <div  class="mt-4">
                Statuts : <span class="fst-italic fw-bold"><?= implode(" - ", unserialize($_SESSION['user']["statuts"])) ?></span>
            </div>

            <button class="mt-4 w-100 btn btn-lg btn-primary" type="submit">Enregistrer</button>
        </form>
    </main>

  <?php include_once(__DIR__ . '/../partials/footer.php'); ?>