<?php
require_once('./include/init.php');






require_once('./include/header.php');

?>


<div class="container d-flex justify-content-center align-items-center" style="width: 100%;height:80vh;" >
    <div id="gradient" class="d-flex justify-content-center align-items-center"></div>
    <div id="card" class=" d-flex flex-column" style="width:40% ; height: 20rem ;">
        <div class="d-flex justify-content-center align-items-center">
            <img class="img-fluid rounded-circle" src="./img/Cézanne_Image5.png" alt="photo de profil" style="width: 100px ; height:100px ;"/>
        </div>
        <h2 class="my-5 text-center"><?= $_SESSION['membre']['nom'] . ' ' . $_SESSION['membre']['prenom'] ?></h2>
        <p class="text-center">email : <span class="fw-semibold"> <?= $_SESSION['membre']['email'] ?> </span></p>
        <p class="text-center">pseudo : <span class="fw-semibold"> <?= $_SESSION['membre']['pseudo'] ?> </span></p>
        <div class="d-flex flex-column align-items-center">
            <a href="?cible=profil&id_membre=<?= $_SESSION['membre']['id_membre'] ?>&pseudo=<?= $_SESSION['membre']['pseudo'] ?>" class="btn btn-outline-dark my-3 shadow rounded my-3 shadow rounded" style="width: 50%;"> Modifier mon profil</a>
            <a href="?cible=mdp&id_membre=<?= $_SESSION['membre']['id_membre'] ?>" class="btn btn-outline-dark my-3 shadow rounded" style="width: 50%;"> Modifier mon mot de passe</a>
        </div>
    </div>
</div>

























<?php

require_once('./include/footer.php');
?>