
<?php


$affichecategories = $pdo->query("SELECT DISTINCT categorie FROM salle ORDER BY categorie ASC");



if (isset($_GET['categorie'])){

$menuCategories = $pdo->query("SELECT * FROM salle WHERE categorie = '$_GET[categorie]'") ;

$afficheSalle = $pdo->query("SELECT id_produit, photo, titre, categorie, prix, description, date_arrivee, date_depart FROM salle as a, produit as b WHERE a.id_salle = b.id_salle AND categorie = '$_GET[categorie]'");

$afficheTitreCategorie = $pdo->query("SELECT categorie FROM salle WHERE categorie = '$_GET[categorie]' ");
$titreCategorie = $afficheTitreCategorie->fetch(PDO::FETCH_ASSOC);

}


if (isset($_GET['id_produit'])){
    
    $afficheProduits = $pdo->query("SELECT * FROM salle as a, produit as b WHERE a.id_salle = b.id_salle AND id_produit = '$_GET[id_produit]'") ;
    $ficheProduit = $afficheProduits->fetch(PDO::FETCH_ASSOC) ;
    
}
if (isset($_GET['id_produit'])){
    $afficheAvis = $pdo->query("SELECT*FROM avis") ;
    $avis = $afficheAvis->fetch(PDO::FETCH_ASSOC);
}