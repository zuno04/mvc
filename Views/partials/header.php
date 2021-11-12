<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"
    />
    <link rel="stylesheet" href="./views/css/style.css" />
    <title>Projet Janvier</title>
  </head>
  <body>
    <!-- Navbar -->
    <nav class="py-3 navbar navbar-expand-lg bg-dark navbar-dark fixed-top">
      <div class="container">
        <a href="index.php?page=index" class="navbar-brand">ToDo</a>

        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navmenu"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navmenu">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Bienvenue, 
                    <?php if (isset($_SESSION['user']) && in_array('admin', unserialize($_SESSION['user']['statuts']))): ?>
                        <?= $_SESSION['user']['first_name'] ?>
                    <?php else: ?>
                        <?= "visiteur" ?>
                    <?php endif; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                    <?php if (isset($_SESSION['user'])): ?>
                        <?php if (in_array('admin', unserialize($_SESSION['user']['statuts']))): ?>
                        <li><a class="dropdown-item" href="#">Gérer les utilisateurs</a></li>
                        <li><a class="dropdown-item" href="#">Mon Compte</a></li>
                        <?php endif; ?>
                        <li><a class="dropdown-item" href="index.php?page=logout">Déconnexion</a></li>
                    <?php else: ?>
                    <li><a class="dropdown-item" href="index.php?page=login">Vous connecter</a></li>
                    <?php endif; ?>
                </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>