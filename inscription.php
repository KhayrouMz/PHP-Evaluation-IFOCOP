<?php
require_once('./include/init.php');


if(internauteConnecte()){
    header('location: ' . URL . 'profil.php');
}

if ($_POST){


    if(!isset($_POST['pseudo']) || !preg_match('#^[a-zA-Z0-9-_.]{3,20}$#', $_POST['pseudo'])){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format pseudo !</div>';
    }
    if(!isset($_POST['mdp']) || strlen($_POST['mdp']) < 3 || strlen($_POST['mdp']) > 20){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format mot de passe !</div>';
    }
    if(!isset($_POST['nom']) || iconv_strlen($_POST['nom']) < 3 || iconv_strlen($_POST['nom']) > 20){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format nom !</div>';
    }
    if(!isset($_POST['prenom']) || iconv_strlen($_POST['prenom']) < 3 || iconv_strlen($_POST['prenom']) > 20){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format prenom !</div>';
    }
    if(!isset($_POST['email']) || !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format email !</div>';
    }
    if(!isset($_POST['civilite']) || $_POST['civilite'] != "f" && $_POST['civilite'] != 'm'){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format civilité !</div>';
    }

    $verifPseudo = $pdo->prepare("SELECT pseudo FROM membre WHERE pseudo = :pseudo");
    $verifPseudo->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
    $verifPseudo->execute();

    
    if($verifPseudo->rowCount() == 1){
        $erreur .= "<div class='alert alert_danger' role='alert'>Erreur ce pseudo n'est pas disponible ! </div>";
    }

    
    $_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT);


    
    if (empty($erreur)){
        
        $insecrireUser = $pdo->prepare("INSERT INTO membre(pseudo, mdp, nom, prenom, email, civilite, date_enregistrement) VALUES (:pseudo, :mdp, :nom, :prenom, :email, :civilite, NOW())");
        $insecrireUser->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
        $insecrireUser->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR);
        $insecrireUser->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
        $insecrireUser->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
        $insecrireUser->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $insecrireUser->bindValue(':civilite', $_POST['civilite'], PDO::PARAM_STR);
        $insecrireUser->execute();

        header('location:'.URL.'connexion.php?action=validate');
    }
}

require_once('./include/header.php');



?>

<h2 class="text-center py-5">Formulaire d'inscription</h2>

<?= $erreur ?>


<form class="my-5 col-12" method="POST" action="">

    <div class="row">
        <div class="col-md-4 mt-5">
        <label class="form-label" for="pseudo">Pseudo</label>
        <input class="form-control" type="text" name="pseudo" id="pseudo" placeholder="Votre pseudo" max-length="20" pattern="[a-zA-Z0-9-_.]{3,20}" title="caractères acceptés: majuscules et minuscules, chiffres, signes tels que: - _ . , entre trois et vingt caractères." required>
        </div>

        <div class="col-md-4 mt-5">
        <label class="form-label" for="mdp">Mot de passe</label>
        <input class="form-control" type="password" name="mdp" id="mdp" placeholder="Votre mot de passe" required>
        </div>
        
        <div class="col-md-4 mt-5">
        <label class="form-label" for="email">Email</label>
        <input class="form-control" type="email" name="email" id="email" placeholder="Votre email" required>
        </div>
    </div>

    <div class="row col-12">
        <div class="col-md-4 mt-5">
        <label class="form-label" for="nom">Nom</label>
        <input class="form-control" type="text" name="nom" id="nom" placeholder="Votre nom">
        </div>

        <div class="col-md-4 mt-5">
        <label class="form-label" for="prenom">Prénom</label>
        <input class="form-control" type="text" name="prenom" id="prenom" placeholder="Votre prénom">
        </div>

        <div class="col-4 md-4 mt-4">
        <p><div class="badge badge-dark text-wrap">Civilité</div></p> 
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="civilite" id="civilite1" value="f">
                <label class="form-check-label mx-2" for="civilite1">Femme</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="civilite" id="civilite2" value="m" checked>
                <label class="form-check-label mx-2" for="civilite2">Homme</label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mt-5">
            <label class="form-label" for="ville">Ville</label>
            <input class="form-control" type="text" name="ville" id="ville" placeholder="Votre ville">
        </div>

        <div class="col-md-4 mt-5">
            <label class="form-label" for="code_postal">Code Postal</label>
            <input class="form-control" type="text" name="code_postal" id="code_postal" placeholder="Votre code postal">
        </div>

        <div class="col-md-4 mt-5">
            <label class="form-label" for="adresse">Adresse</label>
            <input class="form-control" type="text" name="adresse" id="adresse" placeholder="Votre adresse">
        </div>
    </div>

    <div class="col-md-1 mt-5">
    <button type="submit" class="btn btn-outline-dark offset-md-4 my-2">Valider</button>
    </div>
    
</form>













<?php require_once('./include/footer.php'); ?>