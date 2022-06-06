<?php
require_once('include/init.php');





require_once('include/header.php');
?>

<div class="dontainer">
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="d-flex justify-content-center align-items-center">
            <h1 class="text-primary fw-semibold me-3"><?= $ficheProduit['categorie']. ' ' . $ficheProduit['titre'] ?> </h1>
            <span class=" ms-4 fs-4"> <span class="fs-4 badge text-bg-primary fw-semibold"> <?= ' '. $avis['note'] ?></span> / 5 </span>
        </div>
        <button type="submit" class="btn btn-outline-primary">Réserver</button>
    </div>
    <hr class="container">
    <div class="d-flex justify-content-between align-items-center">
        <img class="img-fluid" src="<?= URL . 'img/' . $ficheProduit['photo'] ?>" alt="<?= $ficheProduit['titre'] ?>" style="width: 60% ; height: 400px;" >
        <div class="d-flex flex-column justify-content-between" style="width: 35% ;height: 400px;">
            <div>
            <h6 class="mb-2">Description</h6>
            <p><?= $ficheProduit['description'] ?></p>
            </div>
            <div>
            <h6 class="mb-2">Localisation</h6>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d20988.267082138766!2d2.3581992!3d48.88617119999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66ef8d9b909eb%3A0xcea5ae124055c9d!2sH%C3%B4pital%20Bichat%20-%20Claude-Bernard!5e0!3m2!1sfr!2sfr!4v1654422325963!5m2!1sfr!2sfr" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <div class="mt-3 d-flex flex-column justify-content-between">
            <span class="fw-semibold mb-3">Informations complémentaires</span>
            <span class="mb-2"><i class="bi bi-calendar3"></i> Arrivée :  <?= $ficheProduit['date_arrivee'] ?></span>
            <span><i class="bi bi-calendar3"></i> Départ : <?= $ficheProduit['date_depart'] ?></span>
        </div>
        <div class="d-flex flex-column justify-content-between">
            <span class="mt-5 mb-2"><i class="bi bi-people"></i> Capacité : <?= $ficheProduit['capacite'] ?></span>
            <span><i class="bi bi-tags-fill"></i> Catégorie : <?= $ficheProduit['categorie'] ?></span>
        </div>
        <div class="d-flex flex-column justify-content-between">
            <span class="mt-5 mb-2"><i class="bi bi-geo-alt"></i> Adresse : <?= $ficheProduit['adresse'].' '.$ficheProduit['cp'].', '.$ficheProduit['ville'] ?></span>
            <span><i class="bi bi-currency-euro"></i> Tarif : <?= $ficheProduit['prix'] ?> €</span>
        </div>
    </div>
</div>

<div>
    <p class="mt-3" style="font-size: 1.5rem ;">Autre produits</p>
    <hr class="container">
    <?php $afficheSalle = $pdo->query("SELECT * FROM salle as a, produit as b WHERE a.id_salle = b.id_salle");?>
        <div class="row flex-row d-flex justify-content-between align-items-center">
        <?php while ($produit = $afficheSalle->fetch(PDO::FETCH_ASSOC)) : ?>
            
            <a href="fiche_produit.php?id_produit=<?= $produit['id_produit'] ?>" style="width: 15rem ;" > <img src="<?= URL. 'img/' . $produit['photo'] ?>" alt="..." style="width: 13rem;height:16vh;"> </a>
            
        <?php endwhile ; ?>
    </div>
</div>
<hr class="container">

<div class="d-flex justify-content-between align-items-center">
    <a class="fs-5" href="avis_salle.php?id_produit=<?=  $ficheProduit['id_produit'] ?>" style="text-decoration: none ;" >Déposer un commentaire et une note</a>
    <a class="fs-5" href="produit_categorie.php?categorie=<?=  $ficheProduit['categorie'] ?>" style="text-decoration: none ;" >Retour vers le catalogue</a>
</div>














<?php
require_once('./include/footer.php');
?>