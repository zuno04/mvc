<?php 
  //session_start();
  include_once(__DIR__ . '/../partials/header.php'); 

?>

    <main id="main" class='container d-flex justify-content-center main-container'>
        <form method="POST" action="index.php?page=task_add">
            <h1 class="mb-3 h3 fw-normal">Ajout d'une nouvelle tâche</h1>

            <!-- Nom et Type de tache -->
            <div class="row mt-5">
                <div class="col-md-6">
                    <div class="form-floating input-group has-validation">
                        <input name="taskName" id="id_taskName" type="text" class="form-control<?= isset($_SESSION['signup_errors']['prenom']) ? " border-danger" : "" ?>" id="prenom" placeholder="Prénom" required value=<?= isset($_SESSION['signup_correct_data']['prenom']) ? $_SESSION['signup_correct_data']['prenom'] : '' ?>>
                        <label for="id_taskName">Nom de la tâche</label>
                    </div>
                    <?php if(isset($_SESSION['addTask_errors']['nom_tache'])): ?>
                    <small id="passwordHelp" class="mt-2 text-danger">
                        <?= $_SESSION['addTask_errors']['nom_tache'] ?>
                    </small>
                    <?php endif; ?>
                </div>
    
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select" id="id_taskType" name="taskType" required aria-label="Floating label select example">
                            <option selected></option>
                            <option value="Client">Client</option>
                            <option value="Travailleur">Travailleur</option>
                        </select>
                        <label for="id_taskType">type de tâche</label>
                    </div>
                    <?php if(isset($_SESSION['addTask_errors']['type_tache'])): ?>
                    <small id="passwordHelp" class="mt-2 text-danger">
                        <?= $_SESSION['addTask_errors']['type_tache'] ?>
                    </small>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Description -->
            <div class="mt-3 form-floating">
                <textarea name="taskDescription" class="form-control" placeholder="Ecrire La description de la tâche" id="floatingTextarea" required value=<?= isset($_SESSION['addTask_correct_data']['description']) ? $_SESSION['addTask_correct_data']['description'] : '' ?>></textarea>
                <label for="floatingTextarea">Description de la tâche</label>
            </div>

            <?php if(isset($_SESSION['addTask_errors']['description_tache'])): ?>
            <small id="passwordHelp" class="mt-2 text-danger">
                <?=$_SESSION['addTask_errors']['description_tache'] ?>
            </small>
            <?php endif; ?>
            
            <!-- Date debut et Date fin -->
            <div class="row">
                <div class="col-md-6">
                    <label  class="mt-3" for="id_dateDebut">Date début</label>
                    <div class="mt-3">
                        <input name="taskDateDebut" type="text" id="id_dateDebut" required class="form-control flatpickr" data-mindate=today>
                    </div>

                    <?php if(isset($_SESSION['addTask_errors']['password'])): ?>
                    <div class="text-danger"><?= $_SESSION['addTask_errors']['date_debut'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label  class="mt-3" for="id_dateFin">Date fin</label>
                    <div class="mt-3">
                        <input name="taskDateFin" type="text" id="id_dateFin" required class="form-control flatpickr" data-mindate=today>
                    </div>

                    <?php if(isset($_SESSION['addTask_errors']['repassword'])): ?>
                    <div class="text-danger"><?= $_SESSION['addTask_errors']['date_fin'] ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <button class="mt-5 w-100 btn btn-lg btn-primary" type="submit">Enregistrer</button>
        </form>
    </main>

  <?php include_once(__DIR__ . '/../partials/footer.php'); ?>