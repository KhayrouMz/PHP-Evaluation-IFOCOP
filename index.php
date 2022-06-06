<?php
require_once('./include/init.php');



require_once('./include/header.php');


?>

<h1 class="text-center mt-3 mb-3">Lokisalle : Le site idéal pour tous vos évènements professionnels !</h1>

<div class="d-flex justify-content-center align-items-center my-4" >
    <img class="bg-dark" src="<?= URL ?>img/reunion.jpg" alt="" style="width: 100%; height:50vh;">
</div>
<div>

<div class="d-flex flex-column justify-content-between">
<span class="text-primary fs-2 mb-3">Qui somme nous ?</span>
<p class="text-justify" style="text-align: justify">Depuis 2020, Lokisalle s’est spécialisée dans la location de salles de réunion à Paris, Lyon et Marseille. Salles de formation, de réunion, de séminaire, de formation, ou encore de conférence, nous vous proposons une large palette de salles à disposition de tous les professionnels. L’objectif est de permettre à chacun de créer un événement sur-mesure qui lui convient, pour célébrer un lancement de produit, un team building, pour mener à bien une formation ou encore pour organiser un cocktail dinatoire en petit ou en grand comité. Avec notre partenaire culinaire, spécialisé dans la gastronomie française, nous avons à cœur de veiller à votre satisfaction.</p>
</div>

<p class="fs-2 mt-3 mb-3 text-center">Avis des clients chez Lokisalle</p>
<div class="container d-flex justify-content-center align-items-center mt-3 mb-3">
    <img class="img-fluid" src="./img/avis.PNG" alt="" >
</div>

<!--  -->
<?php $afficheAvisSalle = $pdo->query("SELECT * FROM salle as a, avis as b WHERE a.id_salle = b.id_salle") ;
?>
<div class="row d-flex justify-content-around align-items-center m-auto mt-5 mb-5">
    <?php while($avisSalle = $afficheAvisSalle->fetch(PDO::FETCH_ASSOC)) : ?>
    <div class="row card shadow-lg p-3 mb-5 bg-body rounded" style="width: 18rem;">
        <span class="fs-5 mt-3 mb-3"> Vos avis <span class="ms-4 fs-4 badge text-bg-primary fw-semibold"> <?= ' '. $avisSalle['note'] ?></span> / 5 </span>
        <hr>
        <div class="card-body">
        <h4 class="card-title text-primary"> <?= $avisSalle['titre'] ?></h4>
        <p class="card-text mt-3 mb-3"><?= $avisSalle['commentaire'] ?></p>
        <h6 class="card-subtitle mb-2 text-muted ms-3"><?= $avisSalle['date_enregistrement'] ?></h6>
        </div>
    </div>
    <?php endwhile ; ?>
</div>
<?php

require_once('./include/footer.php');

?>