<?php 
  //session_start();
  include_once(__DIR__ . '/../partials/header.php'); 

?>

    <main id="main" class='main-content container d-flex justify-content-center main-container'>
        <form method="POST" action="index.php?page=task_add">
            <h1 class="mb-3 h3 fw-normal">Ajout d'une nouvelle tâche</h1>

            <!-- Nom de la tache -->
            <div class="mt-5">
                <div class="mt-3 form-floating">
                    <input name="nom_tache" type="text" class="form-control <?= isset($_SESSION['addTask_errors']['nom_tache']) ? " border-danger" : "" ?>" id="id_taskName" placeholder="Nom de la tâche" value=<?= isset($_SESSION['addTask_correct_data']['nom_tache']) ? $_SESSION['addTask_correct_data']['nom_tache'] : '' ?>>
                    <label for="id_taskName">Nom de la tâche</label>
                </div>

                <?php if(isset($_SESSION['addTask_errors']['nom_tache'])): ?>
                <small id="passwordHelp" class="mt-2 text-danger">
                    <?= $_SESSION['addTask_errors']['nom_tache'] ?>
                </small>
                <?php endif; ?>
            </div>

            <!-- Description -->
            <div class="mt-3 form-floating">
                <textarea name="description_tache" class="form-control" placeholder="Ecrire La description de la tâche" id="floatingTextarea" required value=<?= isset($_SESSION['addTask_correct_data']['description_tache']) ? $_SESSION['addTask_correct_data']['description_tache'] : '' ?>></textarea>
                <label for="floatingTextarea">Description de la tâche</label>
            </div>

            <?php if(isset($_SESSION['addTask_errors']['description_tache'])): ?>
            <small class="mt-2 text-danger">
                <?=$_SESSION['addTask_errors']['description_tache'] ?>
            </small>
            <?php endif; ?>
            
            <!-- Date debut et Date fin -->
            <div class="row">
                <div class="col-md-6">
                    <label  class="mt-3" for="id_dateDebut">Date début</label>
                    <div class="mt-3">
                        <input name="date_debut_tache" type="text" id="id_dateDebut" required class="form-control flatpickr" data-mindate=today>
                    </div>
                </div>

                <div class="col-md-6">
                    <label  class="mt-3" for="id_dateFin">Date fin</label>
                    <div class="mt-3">
                        <input name="date_fin_tache" type="text" id="id_dateFin" required class="form-control flatpickr" data-mindate=today>
                    </div>
                </div>
            </div>

            <button class="mt-5 w-100 btn btn-lg btn-primary" type="submit">Enregistrer</button>
        </form>
    </main>

  <?php include_once(__DIR__ . '/../partials/footer.php'); ?>