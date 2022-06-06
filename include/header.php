<?php
require_once('init.php');

require_once('affichage.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <title>Document</title>
</head>
<body>
<header class="header-area overlay">
<nav class="navbar navbar-expand-lg bg-light" style="height: 8vh ;">
    <div class="container-fluid">
        <a class="navbar-brand me-5 fw-bolder" href="index.php">LOKISALLE</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item">
            <a class="nav-link active fw-semibold" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item">
            <a class="nav-link fw-semibold l" href="#">Contact</a>
            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle fw-semibold" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Categories
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <?php while($menuCat = $affichecategories->fetch(PDO::FETCH_ASSOC)) : ?>
                <li><a class="dropdown-item fw-semibold" href="<?= URL ?>produit_categorie.php?categorie=<?= $menuCat['categorie'] ?>"><?= ucfirst($menuCat['categorie']) ?></a></li>
                <?php endwhile ; ?>
            </ul>
            </li>
        <?php if (!internauteConnecteAdmin() && !internauteConnecte()) : ?>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle fw-semibold" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Espace Membre
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <li><a class="dropdown-item fw-semibold" href="inscription.php">Inscription</a></li>
                <li><a class="dropdown-item fw-semibold" href="connexion.php">Connexion</a></li>
                <li><a class="dropdown-item fw-semibold" href="#">Réservation</a></li>
            </ul>
            </li>
        <?php endif ; ?>
        <?php if (internauteConnecte()) : ?>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle fw-semibold" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Espace
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <li><a class="dropdown-item fw-semibold" href="<?= URL ?>profil.php">Profil</a></li>
                <li><a class="dropdown-item fw-semibold" href="<?= URL ?>connexion.php?action=deconnexion">Déconnexion</a></li>
                <li><a class="dropdown-item fw-semibold" href="#">Réservation</a></li>
            </ul>
            </li>
        <?php endif ; ?>
        <?php if(internauteConnecteAdmin()) : ?>
            <li class="nav-item">
            <a class="nav-link fw-semibold border border-dark rounded-4 bg-dark text-white" href="./admin/index.php">Admin</a>
            </li>
        <?php endif ; ?>
        </ul>
        </div>
    </div>
    </nav>
</header>

<main class="container m-auto">


