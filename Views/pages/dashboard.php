<?php include_once(__DIR__ . '/../partials/header.php'); ?>

    <main class='container main-container'>
      <h1><?= $_SESSION['user']['isconnected'] == 'Root' ? "Liste des tâches" : "Mes tâches" ?></h1>
      <!-- Button trigger modal -->
      <?php if($_SESSION['user']['isconnected'] == 'Root' || $_SESSION['user']['isconnected'] == 'Client'): ?>
      <button type="button" class="btn btn-success" onclick="showModal()">
        <i class="bi bi-plus-circle-dotted"></i> Ajouter
      </button>
      <?php endif; ?>
   
      <div class="mt-5">
      <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">Nom</th>
                <th scope="col">Description</th>
                <th scope="col">Date Début</th>
                <th scope="col">Date Fin</th>
                <th scope="col">Auteur</th>

                <?php if($_SESSION['user']['isconnected'] != 'Travailleur'): ?>
                <th scope="col">Exécutant</th>
                <?php endif; ?>

                <th scope="col">Etat</th>
                <?php if($_SESSION['user']['isconnected'] == 'Travailleur'): ?>
                <th scope="col">Terminée</th>
                <?php endif; ?>
                <?php if($_SESSION['user']['isconnected'] == 'Root' || $_SESSION['user']['isconnected'] == 'Client'): ?>
                <th></th>
                <th></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($taches as $index=>$tache): ?>

            <!-- Cas du Root -->
            <?php if($_SESSION['user']['isconnected'] == 'Root'): ?>                
            <tr class="<?php if($tache["etat"] == "Terminee") { echo "task-done-bg"; } if($tache["etat"] == "EnCours") { echo "task-going-bg"; } ?>">
                <td><?= $tache["name"] ?></td>
                <td><?= $tache["description"] ?></td>
                <td><?= $tache["date_debut"] ?></td>
                <td><?= $tache["date_fin"] ?></td>
                <td><?= $tache["prenom_auteur"] . " " . $tache["nom_auteur"] ?></td>
                <td>
                    <?= isset($tache["id_utilisateur"]) ? $tache["prenom_executant"] . " " . $tache["nom_executant"] : "<em>Aucun</em> <a onclick='setTask(" . $tache["id"] . ")' class='btn'><i class=\"bi bi-plus-circle-dotted text-info \"></i></a>" ?>
                </td>
                <td><?php if($tache["etat"] == 'EnCours') { echo "En cours"; } else if($tache["etat"] == 'EnAttente') { echo "En attente"; } else { echo "Terminé"; } ?></td>
                <td>
                    <a href="#" class="<?= $tache["etat"] == 'Terminee' ? 'pe-non' : '' ?>e" onclick='<?php if($tache["etat"] != 'Terminee') { echo "showModal(" . $tache["id"] . ", " . json_encode($tache) . ")"; } ?>'>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="<?= $tache["etat"] == 'Terminee' ? '#838688' : '#0d6efd' ?>" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"></path>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"></path>
                        </svg>
                    </a>
                </td>
                <td>
                    <a href="#" onclick="supprimerTache(<?= $tache['id'] ?>)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#f05463" class="bi bi-trash-fill" viewBox="0 0 16 16">
                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"></path>
                        </svg>
                    </a>
                </td>
            </tr>
            <?php endif; ?>
            
            <!-- Cas du Client -->
            <?php if($_SESSION['user']['isconnected'] == 'Client' && $tache["commanditaire"] == $_SESSION["user"]["id"]): ?>
            <tr class="<?php if($tache["etat"] == "Terminee") { echo "task-done-bg"; } if($tache["etat"] == "EnCours") { echo "task-going-bg"; } ?>">
                <td><?= $tache["name"] ?></td>
                <td><?= $tache["description"] ?></td>
                <td><?= $tache["date_debut"] ?></td>
                <td><?= $tache["date_fin"] ?></td>
                <td><?= $tache["prenom_auteur"] . " " . $tache["nom_auteur"] ?></td>
                <td><?= isset($tache["id_utilisateur"]) ? $tache["prenom_executant"] . " " . $tache["nom_executant"] : "<em>Aucun</em>" ?></td>
                <td><?php if($tache["etat"] == 'EnCours') { echo "En cours"; } else if($tache["etat"] == 'EnAttente') { echo "En attente"; } else { echo "Terminé"; } ?></td>
                <td>
                    <a href="#" onclick='showModal(<?= $tache["id"] ?>, <?= json_encode($tache) ?>)'>
                        <i class="bi bi-pencil-square"></i>
                    </a>
                </td>
                <td>
                    <a href="#" onclick="supprimerTache(<?= $tache['id'] ?>)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#f05463" class="bi bi-trash-fill" viewBox="0 0 16 16">
                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"></path>
                        </svg>
                    </a>
                </td>
            </tr>
            <?php endif; ?>

            <!-- Cas du Travailleur -->
            <?php if($_SESSION['user']['isconnected'] == 'Travailleur' && $tache["id_utilisateur"] == $_SESSION["user"]["id"]) : ?>
            <tr class="<?php if($tache["etat"] == "Terminee") { echo "task-done-bg"; } if($tache["etat"] == "EnCours") { echo "task-going-bg"; } ?>">
                <td><?= $tache["name"] ?></td>
                <td><?= $tache["description"] ?></td>
                <td><?= $tache["date_debut"] ?></td>
                <td><?= $tache["date_fin"] ?></td>
                <td><?= $tache["prenom_auteur"] . " " . $tache["nom_auteur"] ?></td>
                <td><?php if($tache["etat"] == 'EnCours') { echo "En cours"; } else if($tache["etat"] == 'EnAttente') { echo "En attente"; } else { echo "Terminé"; } ?></td>
                <td>
                    <div class="form-check form-switch">
                        <input class="form-check-input" onchange="terminerTache(this, <?= $tache['id'] ?>)" type="checkbox" name="tache_terminee_<?= $tache['id'] ?>" id="id_tache_terminee_<?= $tache['id'] ?>" <?php if ($tache["etat"] == "Terminee") echo "checked disabled" ?> />
                    </div>
                </td>
            </tr>
            <?php endif; ?>

            <?php endforeach; ?>
        </tbody>
        </table>
      </div>
    </main>

    <!-- Modal - Attribuer une tache -->
    <div class="modal fade" id="id_attribuer_tache" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="id_attribuer_tache_titre" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="id_attribuer_tache_titre"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <select id="id_liste_travailleurs" class="form-select form-select-sm" aria-label=".form-select-sm example">
                    <option value="0" selected>Choisir un travailleur</option>
                    <?php foreach($travailleurs as $travailleur): ?>
                    <?php if(count(unserialize($travailleur["statuts"])) == 1 && unserialize($travailleur["statuts"])[0] == 'Travailleur'): ?>
                    <option value="<?= $travailleur['id'] ?>"><?= $travailleur['first_name'] . " " . $travailleur['last_name'] ?></option>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button id="id_enregistrer_tache_attribuee" type="button" class="btn btn-primary">Enregistrer</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal - Creer ou Modifier une tache -->
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