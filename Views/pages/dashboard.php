<?php include_once(__DIR__ . '/../partials/header.php'); ?>

    <main class='container main-container'>
      <h1><?= $_SESSION['user']['isconnected'] == 'Root' ? "Liste des tâches" : "Mes tâches" ?></h1>

      <!-- <a href="index.php?page=task_add" class="btn btn-success" ><i class="bi bi-plus-circle-dotted"></i> Ajouter</a> -->
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-success" onclick="showModal()">
        <i class="bi bi-plus-circle-dotted"></i> Ajouter
      </button>
   
      <div class="mt-5">
      <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">Description</th>
                <th scope="col">Date Début</th>
                <th scope="col">Date Fin</th>
                <th scope="col">Auteur</th>
                <th scope="col">Etat</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($taches as $index=>$tache): ?>
            <?php if($_SESSION['user']['isconnected'] == 'Client' && $tache["commanditaire"] == $_SESSION["user"]["id"]): ?>
            <tr>
                <th scope="row"><?= $index + 1 ?></th>
                <td><?= $tache["name"] ?></td>
                <td><?= $tache["description"] ?></td>
                <td><?= $tache["date_debut"] ?></td>
                <td><?= $tache["date_fin"] ?></td>
                <td><?= $tache["prenom_auteur"] . " " . $tache["nom_auteur"] ?></td>
                <td><?php if($tache["etat"] == 'EnCours') { echo "En cours"; } else if($tache["etat"] == 'EnAttente') { echo "En attente"; } else { echo "Terminé"; } ?></td>
                <td><a href="index.php?page=task_edit&task_id=<?= $tache["id"] ?>" class="btn btn-primary"><i class="bi bi-pencil-square"></i></a></td>
                <td><a href="index.php?page=delete_task&task_id=<?= $tache["id"] ?>" class="btn btn-danger"><i class="bi bi-trash"></i></a></td>
            </tr>
            <?php endif; ?>

            <?php if($_SESSION['user']['isconnected'] == 'Root'): ?>                
            <tr>
                <th scope="row"><?= $index + 1 ?></th>
                <td><?= $tache["name"] ?></td>
                <td><?= $tache["description"] ?></td>
                <td><?= $tache["date_debut"] ?></td>
                <td><?= $tache["date_fin"] ?></td>
                <td><?= $tache["prenom_auteur"] . " " . $tache["nom_auteur"] ?></td>
                <td><?php if($tache["etat"] == 'EnCours') { echo "En cours"; } else if($tache["etat"] == 'EnAttente') { echo "En attente"; } else { echo "Terminé"; } ?></td>
                <td><button class="btn btn-primary" onclick='showModal(<?= $tache["id"] ?>, <?= json_encode((Object)$tache) ?>)'><i class="bi bi-pencil-square"></i></button></td>
                <td><button class="btn btn-danger" onclick="supprimerTache(<?= $tache['id'] ?>)"><i class="bi bi-trash"></i></button></td>
            </tr>
            <?php endif; ?>

            <?php if($_SESSION['user']['isconnected'] == 'Travailleur' && $tache["id_user"] == $_SESSION["user"]["id"]) : ?>
            <tr>
                <th scope="row"><?= $index + 1 ?></th>
                <td><?= $tache["name"] ?></td>
                <td><?= $tache["description"] ?></td>
                <td><?= $tache["date_debut"] ?></td>
                <td><?= $tache["date_fin"] ?></td>
                <td><?= $tache["prenom_auteur"] . " " . $tache["nom_auteur"] ?></td>
                <td><?php if($tache["etat"] == 'EnCours') { echo "En cours"; } else if($tache["etat"] == 'EnAttente') { echo "En attente"; } else { echo "Terminé"; } ?></td>
            </tr>
            <?php endif; ?>

            <?php endforeach; ?>
        </tbody>
        </table>
      </div>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="id_modal_tache" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="idTaskModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="idTaskModalTitle"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="id_task_add">

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
                    <textarea name="description_tache" class="form-control" placeholder="Ecrire La description de la tâche" id="id_taskDescription" required value=<?= isset($_SESSION['addTask_correct_data']['description_tache']) ? $_SESSION['addTask_correct_data']['description_tache'] : '' ?>></textarea>
                    <label for="id_taskDescription">Description de la tâche</label>
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
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            <button type="button" id="addTaskButton" class="btn btn-primary" >Enregistrer</button>
        </div>
        </div>
    </div>
    </div>

<?php include_once(__DIR__ . '/../partials/footer.php'); ?>