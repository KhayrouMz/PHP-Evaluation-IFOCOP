<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
  <title>Document</title>
</head>
<body>
  <header>
  <nav class="navbar navbar-expand-lg bg-dark d-flex justify-content-end" style="height: 8vh ;">
    <div class=" me-5" style="padding-right: 10em;">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link active text-light fw-semibold me-3" aria-current="page" href="../index.php">Home</a>
          <a class="nav-link me-3 fw-semibold border border-dark rounded-4 bg-white text-dark " href="index.php">Admin</a>
          <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle fw-normal text-white fw-semibold" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Menu Admin
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <li><a class="dropdown-item fw-semibold" href="<?= URL ?>admin/gestion_membre.php">Gestion des membres</a></li>
                <li><a class="dropdown-item fw-semibold" href="<?= URL ?>admin/gestion_salle.php">Gestion des salles</a></li>
                <li><a class="dropdown-item fw-semibold" href="<?= URL ?>admin/gestion_produit.php">Gestion des produits</a></li>
                <li><a class="dropdown-item fw-semibold" href="<?= URL ?>admin/gestion_avis.php">Gestion des avis</a></li>
                <li><a class="dropdown-item fw-semibold" href="#">Gestion des commandes</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>
  </header>
  <main class="container">
