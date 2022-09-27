<?php
require_once('include/init.php');

if ($_GET['id_membre']){


$inscrireUser = $pdo->prepare("INSERT INTO commande(id_membre , id_produit, prix, date_enregistrement) VALUES (:id_membre , :id_produit, :prix, NOW() )");

$inscrireUser->bindValue(':id_membre', $_SESSION['membre']['id_membre'], PDO::PARAM_INT);
$inscrireUser->bindValue(':id_produit', $reservation['id_produit'], PDO::PARAM_INT);
$inscrireUser->bindValue(':prix', $reservation['prix'], PDO::PARAM_INT);
$inscrireUser->bindValue(':date_enregistrement', $_POST['date_enregistrement'], PDO::PARAM_STR);

$inscrireUser->execute();

}

require_once('include/header.php');
?>

<div class="dontainer">
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="d-flex justify-content-center align-items-center">
            <h1 class="text-primary fw-semibold me-3"><?= $ficheProduit['categorie']. ' ' . $ficheProduit['titre'] ?> </h1>
            <span class=" ms-4 fs-4"> <span class="fs-4 badge text-bg-primary fw-semibold"> <?= ' '. $avis['note'] ?></span> / 5 </span>
        </div>
        <?php if (internauteConnecte() || internauteConnecteAdmin()) : ?>
        <a href="reservation.php?id_membre=<?= $_SESSION['membre']['id_membre'] ?>" >
            <button type="submit" class="btn btn-outline-primary">Réserver</button>

        </a>
        <?php else : ?>
        <a href="connexion.php" >
            <button type="submit" class="btn btn-outline-primary">Réserver</button>
        <?php endif ?>
        </a>
    </div>
    <hr class="container">
    <div class="d-flex justify-content-between align-items-center mt-5">
        <img class="img-fluid" src="<?= URL . 'img/' . $ficheProduit['photo'] ?>" alt="<?= $ficheProduit['titre'] ?>" style="width: 60% ; height: 400px;" >
        <div class="d-flex flex-column justify-content-between" style="width: 35% ;height: 400px;">
            <div>
            <h6 class="mb-2">Description</h6>
            <p style="text-align: justify ; overflow : auto ; height: 8rem ;"><?= $ficheProduit['description'] ?></p>
            </div>
            <div>
            <h6 class="mb-2">Localisation</h6>
            <iframe width="100%" height="200" id="gmap_canvas" src="https://maps.google.com/maps?q=<?= $ficheProduit['adresse'].$ficheProduit['cp'] ?>&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div class="mt-3 d-flex flex-column justify-content-between">
            <span class="fw-semibold mb-3">Informations complémentaires</span>
            <span class="mb-3"><i class="bi bi-calendar3"></i> Arrivée :  <?= $ficheProduit['date_arrivee'] ?></span>
            <span><i class="bi bi-calendar3"></i> Départ : <?= $ficheProduit['date_depart'] ?></span>
        </div>
        <div class="d-flex flex-column justify-content-between">
            <span class="mt-5 mb-3"><i class="bi bi-people"></i> Capacité : <?= $ficheProduit['capacite'] ?></span>
            <span><i class="bi bi-tags-fill"></i> Catégorie : <?= $ficheProduit['categorie'] ?></span>
        </div>
        <div class="d-flex flex-column justify-content-between">
            <span class="mt-5 mb-3"><i class="bi bi-geo-alt"></i> Adresse : <?= $ficheProduit['adresse'].' '.$ficheProduit['cp'].', '.$ficheProduit['ville'] ?></span>
            <span><i class="bi bi-currency-euro"></i> Tarif : <?= $ficheProduit['prix'] ?> €</span>
        </div>
    </div>
</div>

<div>
    <p class="mt-5" style="font-size: 1.5rem ;">Autre produits</p>
    <hr class="container">
    <?php $afficheSalle = $pdo->query("SELECT * FROM salle as a, produit as b WHERE a.id_salle = b.id_salle ORDER BY a.id_salle ASC LIMIT 4");?>
        <div class="row flex-row d-flex justify-content-between align-items-center">
        <?php while ($produit = $afficheSalle->fetch(PDO::FETCH_ASSOC)) : ?>
        
            <a class="mb-2" href="fiche_produit.php?id_produit=<?= $produit['id_produit'] ?>" style="width: 15rem ;" > <img src="<?= URL. 'img/' . $produit['photo'] ?>" alt="..." style="width: 13rem;height:16vh;"> </a>
            
        <?php endwhile ; ?>
    </div>
</div>
<hr class="container">

<div class="d-flex justify-content-between align-items-center mt-5 mb-5">
    <a class="fs-5" href="avis_salle.php?id_produit=<?=  $ficheProduit['id_produit'] ?>" style="text-decoration: none ;" >Déposer un commentaire et une note</a>
    <a class="fs-5" href="produit_categorie.php?categorie=<?=  $ficheProduit['categorie'] ?>" style="text-decoration: none ;" >Retour vers le catalogue</a>
</div>











<?php
require_once('./include/footer.php');
?>