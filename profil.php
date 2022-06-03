<?php

require_once('./include/header.php');

?>



<div class="row justify-content-around py-5">
    <div class="col-md-3 text-center">
        <ul class="list-group">
            
            <li class="btn btn-outline-success text-dark my-3 shadow bg-white rounded"><?= $_SESSION['membre']['nom'] ?></li>
            <li class="btn btn-outline-success text-dark my-3 shadow bg-white rounded"><?= $_SESSION['membre']['prenom'] ?></li>
            <li class="btn btn-outline-success text-dark my-3 shadow bg-white rounded"><?= $_SESSION['membre']['email'] ?></li>
            
            
        </ul>
        <a href="?cible=profil&id_membre=<?= $_SESSION['membre']['id_membre'] ?>&pseudo=<?= $_SESSION['membre']['pseudo'] ?>" class="btn btn-outline-success text-dark my-3 shadow bg-white rounded"><i class="bi bi-pen-fill text-success"></i> Modifier mon profil</a>
        <a href="?cible=mdp&id_membre=<?= $_SESSION['membre']['id_membre'] ?>" class="btn btn-outline-success text-dark my-3 shadow bg-white rounded"><i class="bi bi-pen-fill text-success"></i> Modifier mon mot de passe</a>
    </div>
</div>


























<?php

require_once('./include/footer.php');
?>