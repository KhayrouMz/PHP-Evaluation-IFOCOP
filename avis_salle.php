<?php
require_once('./include/init.php');


if ($_POST){
    if(!isset($_POST['commentaire']) || strlen($_POST['commentaire']) < 3 || strlen($_POST['commentaire']) > 255){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format commentaire !</div>';
    }

    if(!isset($_POST['note'])){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format code postal !</div>';
    }

    

    if(empty($erreur)){
            if(isset($_GET['id_produit'])){
            
            $queryAvis = $pdo->query("SELECT * FROM salle as a, produit as b WHERE a.id_salle = b.id_salle AND id_produit = '$_GET[id_produit]'") ;
            $avisActuel = $queryAvis->fetch(PDO::FETCH_ASSOC);
            
            
            $avisUser = $pdo->prepare("INSERT INTO avis (commentaire, note, date_enregistrement, id_salle, id_membre) VALUES (:commentaire, :note, NOW(), :id_salle, :id_membre) ");
            $avisUser->bindValue(':commentaire', $_POST['commentaire'], PDO::PARAM_STR);
            $avisUser->bindValue(':note', $_POST['note'], PDO::PARAM_INT);
            $avisUser->bindValue(':id_salle', $avisActuel['id_salle'], PDO::PARAM_INT);
            $avisUser->bindValue(':id_membre', $_SESSION['membre']['id_membre'], PDO::PARAM_INT);
            $avisUser->execute();

            $content .= '<div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
            <strong>Félicitations !</strong> Insertion du produit réussie !
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
        }
    }
}



require_once('./include/header.php');


?>


<h2 class="d-flex justify-content-center align-items-center my-5 mb-5">Votre commentaire pour la salle : <span class="d-flex justify-content-center align-items-center badge text-bg-dark fw-semibold ms-3"><?= ' '.$ficheProduit['titre'] ?></span> </h2>



<?= $content ?>
<?= $erreur ?>


<div class="container" style="height: 80vh ;" >
    <form id="monForm" method="POST" enctype="multipart/form-data">
        <div class="">
            <div class="form-floating row mt-5">
                <textarea class="form-control" placeholder="Leave a comment here" id="commentaire" name="commentaire" style="height: 100px"></textarea>
                <label for="commentaire">Laissez un commentaire</label>
            </div>
            <div class="row mt-5 d-flex justify-content-center align-items-center">
                <div class="col-md-4 mt-3 d-flex justify-content-center align-items-center">
                    <label class="badge badge-dark text-dark" for="note">Donnez un avis sur la salle (de 1 jusqu'a 5): </label>
                    <select class="form-select" name="note" id="note" style="width:50% ;">
                        <option class="text-dark" value="1">1</option>
                        <option class="text-dark" value="2">2</option>
                        <option class="text-dark" value="3">3</option>
                        <option class="text-dark" value="4">4</option>
                        <option class="text-dark" value="5">5</option>
                    </select>
                </div>
            </div>
    <!-- <style>
    .rating a {
        color: #aaa;
        text-decoration: none;
        font-size: 3em;
        transition: color .4s;
    }
    .rating a:hover,
    .rating a:focus {
        color: orange;
        cursor: pointer;
    }
    .rating a:hover ~ a,
    .rating a:focus ~ a {
        color: orange;
    }
    </style>
            <div class="row mt-5 d-flex justify-content-center align-items-center">
                <div class="col-md-4 mt-3">
                    <label class="badge badge-dark text-dark mb-3" for="note">Donnez un avis sur la salle : </label>
                    <div class="rating" name="note" id="note">
                        <a href="#5" value="5" title="Donner 5 étoiles">☆</a>
                        <a href="#4" value="4" title="Donner 4 étoiles">☆</a>
                        <a href="#3" value="3" title="Donner 3 étoiles">☆</a>
                        <a href="#2" value="2" title="Donner 2 étoiles">☆</a>
                        <a href="#1" value="1" title="Donner 1 étoile">☆</a>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="col-md-1 mt-5 mb-5">
            <button type="submit" class="btn btn-outline-dark offset-md-4 my-2">Valider</button>
        </div>
    </form>


</div>

















<?php

require_once('./include/footer.php');

?>