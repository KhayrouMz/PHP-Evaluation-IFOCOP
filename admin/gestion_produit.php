<?php
require_once('../include/init.php');

if (!internauteConnecteAdmin()){
    header('location:'.URL.'connexion.php');
    exit();
}

if (isset($_GET['action'])){
        if($_POST){
            if(!isset($_POST['prix']) || !preg_match('#^[0-9]{1,4}$#', $_POST['prix'])){
                $erreur .= '<div class="alert alert-danger" role="alert">Erreur format prix !</div>';
            }
            if (!isset($_POST['date_arrivee']) ){
                $erreur .= '<div class="alert alert-danger" role="alert">Erreur format date d\'arrivée !</div>';
            }
            if (!isset($_POST['date_depart']) ){
                $erreur .= '<div class="alert alert-danger" role="alert">Erreur format date de départ !</div>';
            }
            
            if (!isset($_POST['id_salle'])){
                $erreur .= '<div class="alert alert-danger" role="alert">Erreur vous n\'avez pas selectionné votre salle !</div>';
            }
            // if(!isset($_POST['etat']) || $_POST['etat'] != "libre" && $_POST['etat'] != "reservation"){
            //     $erreur .= '<div class="alert alert-danger" role="alert">Erreur format etat !</div>';
            // }
            if (empty($erreur)){
                if($_GET['action'] == 'update'){
                    $modifierProduit = $pdo->prepare("UPDATE produit SET id_produit = :id_produit, date_arrivee = :date_arrivee, date_depart = :date_depart, id_salle = :id_salle, prix = :prix WHERE id_produit = :id_produit ");
                    $modifierProduit->bindValue(':id_produit', $_POST['id_produit'], PDO::PARAM_INT);
                    $modifierProduit->bindValue(':date_arrivee', $_POST['date_arrivee'], PDO::PARAM_STR);
                    $modifierProduit->bindValue(':date_depart', $_POST['date_depart'], PDO::PARAM_STR);
                    $modifierProduit->bindValue(':id_salle', $_POST['id_salle'], PDO::PARAM_INT);
                    $modifierProduit->bindValue(':prix', $_POST['prix'], PDO::PARAM_INT);
                    // $modifierProduit->bindValue(':etat', $_POST['etat'], PDO::PARAM_STR);
                    $modifierProduit->execute();
            }else{
                $ajouterProduit = $pdo->prepare("INSERT INTO produit (date_arrivee, date_depart, id_salle, prix) VALUES (:date_arrivee, :date_depart, :id_salle, :prix)");
                $ajouterProduit->bindValue(':date_arrivee', $_POST['date_arrivee'], PDO::PARAM_STR);
                $ajouterProduit->bindValue(':date_depart', $_POST['date_depart'], PDO::PARAM_STR);
                $ajouterProduit->bindValue(':id_salle', $_POST['id_salle'], PDO::PARAM_INT);
                $ajouterProduit->bindValue(':prix', $_POST['prix'], PDO::PARAM_INT);
                // $ajouterProduit->bindValue(':etat', $_POST['etat'], PDO::PARAM_STR);
                $ajouterProduit->execute();

                $content .= '<div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
                <strong>Félicitations !</strong> Insertion du produit réussie !
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
            }
        }
    }
    if($_GET['action'] == 'update' ){
        $queryProduits = $pdo->query("SELECT * FROM produit WHERE id_produit = '$_GET[id_produit]' ");
        $produitActuel = $queryProduits->fetch(PDO::FETCH_ASSOC);
    }

    $id_produit = (isset($produitActuel['id_produit'] )) ? $produitActuel['id_produit'] : "";
    $date_arrivee = (isset($produitActuel['date_arrivee'] )) ? $produitActuel['date_arrivee'] : "";
    $date_depart = (isset($produitActuel['date_depart'] )) ? $produitActuel['date_depart'] : "";
    $id_salle = (isset($produitActuel['id_salle'] )) ? $produitActuel['id_salle'] : "";
    $prix = (isset($produitActuel['prix'] )) ? $produitActuel['prix'] : "";
    // $etat = (isset($produitActuel['etat'] )) ? $produitActuel['etat'] : "";

    if($_GET['action'] == 'delete' ){
        $pdo->query(" DELETE FROM produit WHERE id_produit = '$_GET[id_produit]'");
    }


}



require_once('./includeAdmin/header.php');
?>
<h1 class="text-center my-5"><div class="badge badge-warning text-dark p-3">Gestion des produits</div></h1>
<?= $erreur ?>

<?php if(isset($_GET['action'])) : ?>
<form method="POST">
<input type="hidden" name="id_produit" value="<?= $id_produit ?>">
    <div class="row mt-5 offset-2">
        <div class="col-md-4">
            <?php $dateTime = $pdo->query("SELECT date_arrivee, date_depart FROM produit") ;
            $date = $dateTime->fetch(PDO::FETCH_ASSOC) ?>
            <label class="form-label" for="date_arrivee"><div class="badge badge-dark text-dark">Date d'arrivée</div></label>
            <input class="form-control" type="datetime-local" name="date_arrivee" value="<?= $date_arrivee ?>"  id="date_arrivee"  placeholder="date_arrivee">
        </div>
        <div class="col-md-4">
            <label class="form-label" for="date_depart"><div class="badge badge-dark text-dark">Date d'arrivée</div></label>
            <input class="form-control" type="datetime-local" name="date_depart" value="<?= $date_depart ?>" id="date_depart"  placeholder="date_depart">
        </div>
    </div>
    <div class="row mt-5 offset-2">
        <div class="col-md-4">
            <label class="form-label" for="id_salle"><div class="badge badge-dark text-dark">Salle</div></label>
            <select class="form-select" name="id_salle" id="id_salle">
                <?php $afficheSalles = $pdo->query("SELECT DISTINCT id_salle, titre, ville FROM salle ORDER BY id_salle ASC") ;?>
                <option>Choisissez le ID de la salle</option>
                <?php while( $salle = $afficheSalles->fetch(PDO::FETCH_ASSOC) ): ?>
                        
                        <option class="text-dark" value=" <?= $salle['id_salle'] ?>"<?= ($id_salle == $salle['id_salle']) ? 'selected' : "" ?>><?= $salle['id_salle'].'-'.$salle['titre'].'-'.$salle['ville'] ?></option>

                        <?php endwhile ; ?>
            </select>
        </div>
        
        <div class="col-md-4">
            <label class="form-label" for="prix"><div class="badge badge-dark text-dark">Prix</div></label>
            <input class="form-control" type="text" name="prix" value="<?= $prix ?>" id="prix"  placeholder="Prix">
        </div>
    </div>
    <div class="col-md-1 mt-5">
        <button type="submit" class="btn btn-outline-dark offset-md-4 my-2">Valider</button>
    </div>
</form>
<?php endif ; ?>
<?php $queryproduits = $pdo->query("SELECT id_produit FROM produit") ?>
<h2 class="py-5">Nombre de produit en base de données: <?= $queryproduits->rowCount() ?></h2>

<div class="row justify-content-center py-5">
    <a href='?action=add' class="d-flex justify-content-center align-items-center">
        <button type="button" class="btn btn-sm btn-outline-dark shadow rounded">
        <i class="bi bi-plus-circle-fill"></i> Ajouter un produit
        </button>
    </a>
</div>

<table class="table  text-center">
<?php $affciheProduits = $pdo->query("SELECT * FROM produit ORDER BY id_produit ASC") ?>
    <thead>
        <tr>
            <?php for($i = 0; $i < $affciheProduits->columnCount(); $i++):
                $colonne = $affciheProduits->getColumnMeta($i) ?>
                <th><?= $colonne['name'] ?></th>
            <?php endfor?>
            <th colspan='2'>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while( $produit = $affciheProduits->fetch(PDO::FETCH_ASSOC) ): ?>
        <tr>
            <?php foreach( $produit as $key => $value): ?>
                <?php if( $key == 'photo'): ?>
                    <td><img class='img-fluid' src="<?= URL . "./img/" . $value ?> " width ="50"></td>
                <?php else: ?>
                    <!-- pour tous les autres cas, RAS, affichage de la valeur simplement -->
                    <td><?= $value ?></td>
                <?php endif ?>
            <?php endforeach ?>
            <td><a href='?action=update&id_produit=<?= $produit['id_produit'] ?>'><i class="bi bi-pencil-square text-dark" style="font-size: 1.5rem;"></i></a></td>
            <td><a href="?action=delete&id_produit=<?= $produit['id_produit'] ?>" data-toggle="modal" data-target="#confirm-delete"><i class="bi bi-trash text-danger" style="font-size: 1.5rem;"></i></a></td>
        </tr>
        <?php endwhile ?>
    </tbody>
</table>

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





<?php require_once('./includeAdmin/footer.php') ?>