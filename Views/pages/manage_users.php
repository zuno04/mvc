<?php include_once(__DIR__ . '/../partials/header.php'); ?>

    <main class='container main-container'>
      <h1>Gestion des utilisateurs</h1>

      <div class="mt-5">
      <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Prénom</th>
                <th scope="col">Nom</th>
                <th scope="col">Email</th>
                <th scope="col">Statuts</th>
                <th scope="col">Nbre de tâches</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $index=>$user): ?>
            
            <tr>
                <th scope="row"><?= $index + 1 ?></th>
                <td><?= $user["first_name"] ?></td>
                <td><?= $user["last_name"] ?></td>
                <td><?= $user["email"] ?></td>
                <td><?= implode(" - ", unserialize($user["statuts"])) ?></td>
                <td> --</td>
                <td><a href="index.php?page=user_edit&user_id=<?= $user["id"] ?>" class="btn btn-primary" ><i class="bi bi-pencil-square"></i></a></td>
            </tr>

            <?php endforeach; ?>
        </tbody>
        </table>
      </div>
    </main>

<?php include_once(__DIR__ . '/../partials/footer.php'); ?>