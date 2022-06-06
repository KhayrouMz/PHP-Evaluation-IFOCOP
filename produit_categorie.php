<?php
require_once('./include/init.php');



require_once('./include/header.php');



?>



<h1 class="d-flex justify-content-center align-items-center my-5 mb-5">Liste des salles de type : <span class="d-flex justify-content-center align-items-center badge text-bg-dark fw-semibold ms-3"><?= ' '.$titreCategorie['categorie'] ?></span> </h1>

</div>


<?php if (isset($_GET['categorie']))  : ?>

<div class="container">
    <div class="row d-flex justify-content-around align-items-center m-auto">
                <?php while($produit = $afficheSalle->fetch(PDO::FETCH_ASSOC)) : ?>
                    <div class="card shadow-lg mb-5 bg-body rounded d-flex flex-column justify-content-between my-2 ms-2" style="width: 20rem;">
                        <img src="<?= URL . 'img/' . $produit['photo'] ?>" class="card-img-top img-fluid m-auto" alt="..." style="width: 300px;height:200px;" >
                        <hr>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title text-primary"><?= $produit['titre'].' salle de '.$produit['categorie'] ?></h5>
                                <span class="text-danger fw-semibold"><?= $produit['prix'] ?> €</span>
                            </div>
                            <p class="card-text"><?= $produit['description'] ?></p>
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
<?php endif ; ?>







<?php

require_once('./include/footer.php');

?>