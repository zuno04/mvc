<?php include_once(__DIR__ . '/../partials/header.php'); ?>

    <main class='main-content container main-container'>
      <h1>Utilisateur : <?= $user['first_name'] . " " . $user['last_name'] ?></h1>

      <div class="mt-5 row">
        <div class="col-md-6">
          <form class="p-5 border" method="POST" action="index.php?page=user_edit&user_id=<?= $user["id"] ?>">
            <legend class="w-auto px-2">Statuts:</legend>
            <div class="form-check form-switch">
              <input class="form-check-input" name="statut_travailleur" type="checkbox" id="travailleur_id" <?php if (in_array('Travailleur', unserialize($user['statuts']))) echo "checked" ?>>
              <label class="form-check-label" for="travailleur_id">Travailleur</label>
            </div>
            <div class="form-check form-switch">
              <input class="form-check-input"  name="statut_root" type="checkbox" id="root_id" <?php if (in_array('Root', unserialize($user['statuts']))) echo "checked" ?>>
              <label class="form-check-label" for="root_id">Root</label>
            </div>
            <div class="form-check form-switch">
              <input class="form-check-input"  name="statut_client" type="checkbox" id="client_id" <?php if (in_array('Client', unserialize($user['statuts']))) echo "checked" ?>>
              <label class="form-check-label" for="client_id">Client</label>
            </div>
            
            <input type="hidden" name="status_updated" value="<?= $user['statuts'] ?>">
            <button class="mt-5 w-100 btn btn-lg btn-primary" type="submit">Enregistrer</button>
          </form>
        </div>
      </div>
    </main>

<?php include_once(__DIR__ . '/../partials/footer.php'); ?>