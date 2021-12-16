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
                <th scope="col">Type</th>
                <th scope="col">Description</th>
                <th scope="col">Date Début</th>
                <th scope="col">Date Fin</th>
                <th scope="col">Exécutant</th>
                <th scope="col">Etat</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($taches as $index=>$tache): ?>
            <?php if($tache == 'Root'): ?>
            <tr>
                <th scope="row"><?= $index + 1 ?></th>
                <td><?= $tache["name"] ?></td>
                <td><?= $tache["type"] ?></td>
                <td><?= $tache["description"] ?></td>
                <td><?= $tache["date_debut"] ?></td>
                <td><?= $tache["date_fin"] ?></td>
                <td><?= count(unserialize($tache["executants"])) ?></td>
                <td><?= $tache["etat"] == 'Encours' ? "En cours" : "Terminé" ?></td>
                <td><a href="index.php?page=user_edit&user_id=<?= $tache["id"] ?>" class="btn btn-primary" ><i class="bi bi-pencil-square"></i></a></td>
            </tr>
            <?php endif; ?>

            <?php endforeach; ?>
        </tbody>
        </table>
      </div>
    </main>


<?php include_once(__DIR__ . '/../partials/footer.php'); ?>