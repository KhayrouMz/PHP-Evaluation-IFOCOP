<?php
require_once('./include/init.php');



require_once('./include/header.php');



?>

<h2 class="d-flex justify-content-center align-items-center my-5 mb-5"><span class="d-flex justify-content-center align-items-center badge text-bg-dark fw-semibold ms-3">Toutes les catégories</span> </h2>


<?php $afficheSalle = $pdo->query("SELECT id_produit, photo, titre, categorie, prix, description, date_arrivee, date_depart FROM salle as a, produit as b WHERE a.id_salle = b.id_salle"); ?>
<div class="container">
    <div class="row d-flex justify-content-around align-items-center m-auto">
        <?php while($produit = $afficheSalle->fetch(PDO::FETCH_ASSOC)) : ?>
            <div class="card shadow-lg mb-5 bg-body rounded d-flex flex-column justify-content-between my-2 ms-2" style="width: 26rem;">
                <img src="<?= URL . 'img/' . $produit['photo'] ?>" class="card-img-top img-fluid m-auto" alt="..." style="width: 100%; height:200px; background-size: cover !important;" >
                <hr>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title text-primary"><?= $produit['titre'].' '.$produit['categorie'] ?></h4>
                        <span class="text-danger fw-semibold fs-5"><?= $produit['prix'] ?> €</span>
                    </div>
                    <p class="card-text" style="text-align: justify ;overflow: auto; height:8rem ;"><?= $produit['description'] ?></p>
                    <p class="card-text"> <i class="bi bi-calendar-week"></i> <?= $produit['date_arrivee']. ' au ' . $produit['date_depart'] ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span></span>
                        <a href="fiche_produit.php?id_produit=<?= $produit['id_produit'] ?>" class="text-primary text-decoration-none"> <i class="bi bi-search"></i> Voir +</a>
                    </div>
                </div>
            </div>
        <?php endwhile ; ?>
    </div>
</div>



<?php

require_once('./include/footer.php');

?>