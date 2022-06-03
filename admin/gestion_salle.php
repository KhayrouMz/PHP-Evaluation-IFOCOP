<?php
require_once('../include/init.php');

if(!internauteConnecteAdmin()){
    header('location:' . URL . 'connexion.php');
    exit();
}

// va inclure les cas du add, update et delete
if(isset($_GET['action'])){
    // si je reçois des données d'un formulaire
    if($_POST){

        if(!isset($_POST['titre']) || strlen($_POST['titre']) < 2 || strlen($_POST['titre']) > 20){
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format titre !</div>';
        }
        if(!isset($_POST['description']) || strlen($_POST['description']) < 2 || strlen($_POST['description']) > 100){
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format description !</div>';
        }
        if(!isset($_POST['pays']) || $_POST['pays'] != "france"){
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format pays !</div>';
        }
        if(!isset($_POST['ville']) || strlen($_POST['ville']) < 3 || strlen($_POST['ville']) > 20){
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format ville !</div>';
        }
        if(!isset($_POST['adresse']) || strlen($_POST['adresse']) < 3 || strlen($_POST['adresse']) > 50){
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format adresse !</div>';
        }
        if(!isset($_POST['cp']) || !preg_match('#^[0-9]{5}$#', $_POST['cp'])){
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format code postal !</div>';
        }
        if(!isset($_POST['capacite']) || !preg_match('#^[0-9]{1,4}$#', $_POST['capacite'])){
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format capacite !</div>';
        }
        if(!isset($_POST['categorie']) || $_POST['categorie'] != "rénunion" && $_POST['categorie'] != "bureau" && $_POST['categorie'] != "formation"){
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format civilité !</div>';
        }
        
        $photo_bdd = "";
        if($_GET['action'] == 'update'){
            $photo_bdd = $_POST['photoActuelle'];
        }

        if(!empty($_FILES['photo']['name'])){
            $photo_nom = $_POST['titre'] . '_' . $_FILES['photo']['name'];
            $photo_bdd = "$photo_nom";
            $photo_dossier = RACINE_SITE . "./img/$photo_nom";
            copy($_FILES['photo']['tmp_name'], $photo_dossier);
        }
        if(empty($erreur)){
            if($_GET['action'] == 'update'){
                $modifierSalle = $pdo->prepare("UPDATE salle SET id_salle = :id_salle, titre = :titre, description = :description, photo = :photo, pays = :pays, ville = :ville, adresse = :adresse, cp = :cp, capacite = :capacite, categorie = :categorie WHERE id_salle = :id_salle ");
                $modifierSalle->bindValue(':id_salle', $_POST['id_salle'], PDO::PARAM_INT);
                $modifierSalle->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
                $modifierSalle->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
                $modifierSalle->bindValue(':photo', $photo_bdd, PDO::PARAM_STR);
                $modifierSalle->bindValue(':pays', $_POST['pays'], PDO::PARAM_STR);
                $modifierSalle->bindValue(':ville', $_POST['ville'], PDO::PARAM_STR);
                $modifierSalle->bindValue(':adresse', $_POST['adresse'], PDO::PARAM_STR);
                $modifierSalle->bindValue(':cp', $_POST['cp'], PDO::PARAM_INT);
                $modifierSalle->bindValue(':capacite', $_POST['capacite'], PDO::PARAM_INT);
                $modifierSalle->bindValue(':categorie', $_POST['categorie'], PDO::PARAM_STR);
                $modifierSalle->execute();
                
                $querysalles = $pdo->query("SELECT titre, categorie FROM salle WHERE id_salle = '$_GET[id_salle]' ");
                $salle = $querysalles->fetch(PDO::FETCH_ASSOC);
                $content .= '<div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
                        <strong>Félicitations !</strong> Modification du salle ' . $salle['titre'] . ' ' . $salle['categorie'] . ' réussie !
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            }else{
                $ajouterSalle = $pdo->prepare("INSERT INTO salle (titre, description, photo, pays, ville, adresse, cp, capacite, categorie) VALUES (:titre, :description, :photo, :pays, :ville, :adresse, :cp, :capacite, :categorie) ");
                $ajouterSalle->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
                $ajouterSalle->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
                $ajouterSalle->bindValue(':photo', $photo_bdd, PDO::PARAM_STR);
                $ajouterSalle->bindValue(':pays', $_POST['pays'], PDO::PARAM_STR);
                $ajouterSalle->bindValue(':ville', $_POST['ville'], PDO::PARAM_STR);
                $ajouterSalle->bindValue(':adresse', $_POST['adresse'], PDO::PARAM_STR);
                $ajouterSalle->bindValue(':cp', $_POST['cp'], PDO::PARAM_INT);
                $ajouterSalle->bindValue(':capacite', $_POST['capacite'], PDO::PARAM_INT);
                $ajouterSalle->bindValue(':categorie', $_POST['categorie'], PDO::PARAM_STR);
                $ajouterSalle->execute();
                $content .= '<div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
                        <strong>Félicitations !</strong> Insertion du salle réussie !
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            }
        }
    }

    if($_GET['action'] == 'update' ){
        $querysalles = $pdo->query("SELECT * FROM salle WHERE id_salle = '$_GET[id_salle]' ");
        $salleActuel = $querysalles->fetch(PDO::FETCH_ASSOC);
    }

    $id_salle = (isset($salleActuel['id_salle'] )) ? $salleActuel['id_salle'] : "";
    $titre = (isset($salleActuel['titre'] )) ? $salleActuel['titre'] : "";
    $description = (isset($salleActuel['description'] )) ? $salleActuel['description'] : "";
    $photo = (isset($salleActuel['photo'] )) ? $salleActuel['photo'] : "";
    $pays = (isset($salleActuel['pays'] )) ? $salleActuel['pays'] : "";
    $ville = (isset($salleActuel['ville'] )) ? $salleActuel['ville'] : "";
    $adresse = (isset($salleActuel['adresse'] )) ? $salleActuel['adresse'] : "";
    $cp = (isset($salleActuel['cp'] )) ? $salleActuel['cp'] : "";
    $capacite = (isset($salleActuel['capacite'] )) ? $salleActuel['capacite'] : "";
    $categorie = (isset($salleActuel['categorie'] )) ? $salleActuel['categorie'] : "";

    if($_GET['action'] == 'delete' ){
        $pdo->query(" DELETE FROM salle WHERE id_salle = '$_GET[id_salle]'");
    }
}






require_once('includeAdmin/header.php');
?>

<h1 class="text-center my-5"><div class="badge badge-warning text-dark p-3">Gestion des salles</div></h1>

<?= $erreur ?>
<?= $content ?>

<?php if(!isset($_GET['action']) && !isset($_GET['page'])): ?>
<div class="blockquote alert alert-dismissible fade show mt-5 shadow border border-warning rounded" role="alert">
    <p>Gérez ici votre base de données des salles</p>
    <p>Vous pouvez modifier leurs données, ajouter ou supprimer un salle</p>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php endif ?>

<!-- explication dans gestion_membres.php, car meêm code -->
<?php if(isset($_GET['action'])): ?>
<h2 class="pt-5">Formulaire  des salles</h2>

<!-- l'atttribut enctype="multipart/form-data" permet d'envoyer avec un formulaire des fichiers. Si il n'est pas précisé, cet envoi ne se fera jamais -->
<form id="monForm" class="my-5" method="POST" action=""  enctype="multipart/form-data">

<input type="hidden" name="id_salle" value="<?= $id_salle ?>">

<div class="row mt-5">
    <div class="col-md-4">
    <label class="form-label" for="titre"><div class="badge badge-dark text-dark">Titre</div></label>
    <input class="form-control" type="text" name="titre" value="<?= $titre ?>" id="titre"  placeholder="titre">
    </div>

    <div class="col-md-4">
    <label class="form-label" for="adresse"><div class="badge badge-dark text-dark">Adresse</div></label>
    <input class="form-control" type="text" name="adresse"  value="<?= $adresse ?>" id="adresse"  placeholder="adresse">
    </div>

    <div class="col-md-4">
    <label class="form-label" for="cp"><div class="badge badge-dark text-dark">Code postal</div></label>
    <input class="form-control" type="text" name="cp"  value="<?= $cp ?>" id="cp"  placeholder="cp">
    </div>
</div>

<div class="row justify-content-around mt-5">
    <div class="col-md-6">
    <label class="form-label" for="description"><div class="badge badge-dark text-dark">Description</div></label>
    <!-- pour récupérer l'affichage de la valeur dans le champs textarea, il faut injeecter la variable entre la balise ouvrante et fermante textarea (et pas dans un attribut value="") -->
    <textarea class="form-control" name="description" id="description" placeholder="Description" rows="5"><?= $description ?></textarea>
    </div>
</div>

<div class="row mt-5">

    <div class="col-md-4 mt-3">
        <label class="badge badge-dark text-dark" for="categorie">Catégorie</label>
            <select class="form-select" name="categorie" id="categorie">
                <option value="">Choisissez</option>
                <option class="text-dark" value="rénunion" <?= ($categorie == 'rénunion') ? 'selected' : "" ?> >Rénunion</option>
                <option class="text-dark" value="bureau" <?= ($categorie == 'bureau') ? 'selected' : "" ?>>Bureau</option>
                <option class="text-dark" value="formation" <?= ($categorie == 'formation') ? 'selected' : "" ?>>Formation</option>
            </select>
    </div>


    <div class="col-md-4 mt-3">
        <label class="badge badge-dark text-dark" for="capacite">Capacité</label>
            <select class="form-select" name="capacite" id="capacite">
            <?php for ($i=1 ; $i<=20; $i++) : ?>
                <option class="text-dark" value=" <?= $i?>"<?= ($capacite == $i) ? 'selected' : "" ?> ><?= $i ?></option>
            <?php endfor ; ?>
            </select>
    </div>
    <div class="col-md-4 mt-3">
        <label class="badge badge-dark text-dark" for="pays">Pays</label>
            <select class="form-select" name="pays" id="pays">
                <option value="">Choisissez le pays</option>
                <option class="text-dark" value="france" <?= ($pays == 'france') ? 'selected' : "" ?>>France</option>
            </select>
    </div>
    <div class="row mt-5 offset-2">
        <div class="col-md-4 mt-3">
            <label class="badge badge-dark text-dark" for="ville">Ville</label>
                <select class="form-select" name="ville" id="ville">
                    <option value="">Choisissez la ville</option>
                    <option class="text-dark" value=" paris" <?= ($ville == 'paris') ? 'selected' : "" ?>>Paris</option>
                    <option class="text-dark" value=" lyon" <?= ($ville == 'lyon') ? 'selected' : "" ?>>Lyon</option>
                    <option class="text-dark" value=" marseille " <?= ($ville == 'marseille') ? 'selected' : "" ?>>Marseille</option>
                </select>
        
        </div>


        <div class="col-md-4">
        <label class="form-label" for="photo"><div class="badge badge-dark text-dark mt-3">Photo</div></label>
        <input class="form-control" type="file" name="photo" id="photo" placeholder="Photo">
        </div>
        <!-- ----------------- -->
        <?php if(!empty($photo)): ?>
            <div class="mt-4">
                <p>Vous pouvez changer d'image
                    <img src="<?= URL . './img/' . $photo ?>" width="50px">
                </p>
            </div>
        <?php endif; ?>
        <!-- ci-dessous, un input hidden (aucun besoin de l'afficher) pour récupérer la valeur dans le nouveau name "photoActuelle" pour l'envoyer via le form $_POST à la ligne 60 pour affecter $photo_bdd -->
        <input type="hidden" name="photoActuelle" value="<?= $photo ?>">
    </div>
    <!-- -------------------- -->
</div>

<div class="col-md-1 mt-5">
<button type="submit" class="btn btn-outline-dark offset-md-4 my-2">Valider</button>
</div>

</form>
<?php endif ?>

<!-- explication dans gestion_membres.php, car meêm code -->
<?php $querysalles = $pdo->query("SELECT id_salle FROM salle") ?>
<h2 class="py-5">Nombre de salles en base de données: <?= $querysalles->rowCount() ?></h2>

<div class="row justify-content-center py-5">
    <a href='?action=add' class="d-flex justify-content-center align-items-center">
        <button type="button" class="btn btn-sm btn-outline-dark shadow rounded">
        <i class="bi bi-plus-circle-fill"></i> Ajouter une salle
        </button>
    </a>
</div>

<table class="table text-center">
<?php $afficheSalles = $pdo->query("SELECT * FROM salle ORDER BY id_salle ASC") ?>
    <thead>
        <tr>
            <?php for($i = 0; $i < $afficheSalles->columnCount(); $i++):
                $colonne = $afficheSalles->getColumnMeta($i) ?>
                <th><?= $colonne['name'] ?></th>
            <?php endfor?>
            <th colspan='2'>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while( $salle = $afficheSalles->fetch(PDO::FETCH_ASSOC) ): ?>
        <tr>
            <?php foreach( $salle as $key => $value): ?>
                <?php if( $key == 'photo'): ?>
                    <td><img class='img-fluid' src="<?= URL . "./img/" . $value ?> " width ="50"></td>
                <?php else: ?>
                    <!-- pour tous les autres cas, RAS, affichage de la valeur simplement -->
                    <td><?= $value ?></td>
                <?php endif ?>
            <?php endforeach ?>
            <td><a href='?action=update&id_salle=<?= $salle['id_salle'] ?>'><i class="bi bi-pencil-square text-dark" style="font-size: 1.5rem;"></i></a></td>
            <td><a data-href="?action=delete&id_salle=<?= $salle['id_salle'] ?>" data-toggle="modal" data-target="#confirm-delete"><i class="bi bi-trash text-danger" style="font-size: 1.5rem;"></i></a></td>
        </tr>
        <?php endwhile ?>
    </tbody>
</table>

<!-- modal suppression codepen https://codepen.io/lowpez/pen/rvXbJq -->

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Supprimer article
            </div>
            <div class="modal-body">
                Etes-vous sur de vouloir retirer cet article de votre panier ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
                <a class="btn btn-danger btn-ok">Supprimer</a>
            </div>
        </div>
    </div>
</div>

<!-- modal -->



<?php require_once('includeAdmin/footer.php');