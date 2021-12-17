<?php include_once(__DIR__ . '/../partials/header.php'); ?>

    <main class='container main-container'>
      <h1><?= $_SESSION['user']['isconnected'] == 'Root' ? "Liste des tâches" : "Mes tâches" ?></h1>

      <a href="index.php?page=task_add" class="btn btn-success" ><i class="bi bi-plus-circle-dotted"></i> Ajouter</a> une nouvelle tâche
   
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
                <td><a href="index.php?page=task_edit&task_id=<?= $tache["id"] ?>" class="btn btn-primary"><i class="bi bi-pencil-square"></i></a></td>
                <td><a href="index.php?page=delete_task&task_id=<?= $tache["id"] ?>" class="btn btn-danger"><i class="bi bi-trash"></i></a></td>
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


<?php include_once(__DIR__ . '/../partials/footer.php'); ?>