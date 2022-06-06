<?php
require_once('../include/init.php');

require_once('../include/affichage.php');


if (!internauteConnecteAdmin()){
    header('location:'.URL.'../connexion.php');
    exit();
}

if (isset($_GET['action'])){
    if ($_POST){
        if(!isset($_POST['commentaire']) || strlen($_POST['commentaire']) < 3 || strlen($_POST['commentaire']) > 255){
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format commentaire !</div>';
        }

        if(!isset($_POST['note'])){
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format code postal !</div>';
        }

        

        if(empty($erreur)){
                if(($_GET['action'] == 'update')){
                
                $modifAvis = $pdo->prepare("UPDATE avis SET id_avis = :id_avis, commentaire = :commentaire, note = :note, date_enregistrement = NOW() WHERE id_avis = :id_avis ") ;
                $modifAvis->bindValue(':id_avis', $_POST['id_avis'], PDO::PARAM_INT);
                $modifAvis->bindValue(':commentaire', $_POST['commentaire'], PDO::PARAM_STR);
                $modifAvis->bindValue(':note', $_POST['note'], PDO::PARAM_INT);
                $modifAvis->execute();
            }
        }
    }
    if($_GET['action'] == 'update'){
            
        $avisUser = $pdo->query("SELECT * FROM avis WHERE id_avis = '$_GET[id_avis]' ");
        $avisActuel = $avisUser->fetch(PDO::FETCH_ASSOC);
    }
    
    $id_avis = (isset($avisActuel['id_avis'])) ? $avisActuel['id_avis'] : "";
    $commentaire = (isset($avisActuel['commentaire'])) ? $avisActuel['commentaire'] : "";
    $note = (isset($avisActuel['note'])) ? $avisActuel['note'] : "";
    $id_salle = (isset($avisActuel['id_salle'])) ? $avisActuel['id_salle'] : "";
    $id_membre = (isset($avisActuel['id_membre'])) ? $avisActuel['id_membre'] : "";
    
    if($_GET['action'] == 'delete' ){
        $pdo->query(" DELETE FROM avis WHERE id_avis = '$_GET[id_avis]'");
    }
}

require_once('includeAdmin/header.php');

?>

<h1 class="text-center my-5"><div class="badge badge-warning text-dark p-3">Gestion des avis</div></h1>

<?php if (isset($_GET['action']) && $_GET['action'] == 'update') : ?>

<form id="monForm" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id_avis" value="<?= $id_avis ?>">
    <div class="">
        <div class="form-floating row mt-5">
            <textarea class="form-control" placeholder="Leave a comment here" id="commentaire" name="commentaire" style="height: 100px"> <?= $commentaire ?> </textarea>
            <label for="commentaire">Laissez un commentaire</label>
        </div>
        <div class="row mt-5 d-flex justify-content-center align-items-center">
            <div class="col-md-4 mt-3">
                <label class="badge badge-dark text-dark mb-3" for="note">Donnez un avis sur la salle : </label>
                <select class="form-select" name="note" id="note" style="width:50% ;">
                    <option class="text-dark" value="1" <?= ($note == '1') ? 'selected' : "" ?>>1</option>
                    <option class="text-dark" value="2" <?= ($note == '2') ? 'selected' : "" ?>>2</option>
                    <option class="text-dark" value="3" <?= ($note == '3') ? 'selected' : "" ?>>3</option>
                    <option class="text-dark" value="4" <?= ($note == '4') ? 'selected' : "" ?>>4</option>
                    <option class="text-dark" value="5" <?= ($note == '5') ? 'selected' : "" ?>>5</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-1 mt-5 mb-5">
        <button type="submit" class="btn btn-outline-dark offset-md-4 my-2">Valider</button>
    </div>
</form>

<?php endif ; ?>


<table class="table text-center my-5">
    <?php $afficheavis = $pdo->query("SELECT * FROM avis ORDER BY id_avis ASC ") ?>
    <thead>
        <tr>
            <?php for($i = 0; $i < $afficheavis-> columnCount(); $i++){
                $colonne = $afficheavis->getColumnMeta($i);
                if($colonne['name'] != 'mdp'){ ?>
            <th><?= $colonne['name'] ?></th>
            <?php }
            } ?>
            <th colspan='2'>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while($avis = $afficheavis->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <?php foreach($avis as $key => $value){
                if($key != 'mdp'){ ?>
            <td><?= $value ?></td>
            <?php }
            } ?>
            <td><a href='?action=update&id_avis=<?= $avis['id_avis'] ?>'><i class="bi bi-pencil-square text-dark" style="font-size: 1.5rem;"></i></a></td>
            <td><a href="?action=delete&id_avis=<?= $avis['id_avis'] ?>" data-toggle="modal" data-target="#confirm-delete"><i class="bi bi-trash text-danger" style="font-size: 1.5rem;"></i></a></td>
        </tr>
        <?php endwhile ?>
    </tbody>
</table>











<?php require_once('includeAdmin/footer.php'); ?>