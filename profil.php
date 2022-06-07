<?php
require_once('./include/init.php');

if(!internauteConnecteAdmin()){
    header('location:' . URL . 'connexion.php');
    exit();
}


if(isset($_GET['cible'])){
    if($_POST){
        if($_GET['cible'] == 'profil'){
        if(!isset($_POST['pseudo']) || !preg_match('#^[a-zA-Z0-9-_.]{3,20}$#', $_POST['pseudo'])){
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format pseudo !</div>';
        }
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
        
        $verifPseudo = $pdo->prepare("SELECT pseudo FROM membre WHERE pseudo = :pseudo ");
        $verifPseudo->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
        $verifPseudo->execute();

        if($_GET['pseudo'] != $_POST['pseudo']){
            if($verifPseudo->rowCount() == 1 ){
                    $erreur .= '<div class="alert alert-danger" role="alert">Erreur ce pseudo n\'est pas disponible !</div>';
                }
        }
        
        if(empty($erreur)){
            if($_GET['action'] == "update"){
                $modifUser = $pdo->prepare("UPDATE membre SET id_membre = :id_membre , pseudo = :pseudo , nom = :nom , prenom = :prenom , email = :email WHERE id_membre = :id_membre ");
                $modifUser->bindValue(':id_membre', $_POST['id_membre'], PDO::PARAM_INT);
                $modifUser->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
                $modifUser->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
                $modifUser->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
                $modifUser->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
                $modifUser->execute();

                $queryUser = $pdo->query("SELECT pseudo FROM membre WHERE id_membre = '$_GET[id_membre] ' ");

                $user = $queryUser->fetch(PDO::FETCH_ASSOC);

                foreach($user as $key => $value){
                    if($key != 'mdp'){
                        
                    $_SESSION['membre'][$key] = $value;
                    }
                }
            }
            }else{
                if(!isset($_POST['mdp']) || strlen($_POST['mdp']) < 3 || strlen($_POST['mdp']) > 20){
                    $erreur .= '<div class="alert alert-danger" role="alert">Erreur format mot de passe !</div>';
                }
    
                // hashage du nouveau mdp
                $_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
    
                if(empty($erreur)){
                    // la requete préparée pour la modif du mdp
                    $modifMdp = $pdo->prepare("UPDATE membre SET id_membre = :id_membre, mdp = :mdp WHERE id_membre = :id_membre");
                    $modifMdp->bindValue(':id_membre', $_POST['id_membre'], PDO::PARAM_INT);
                    $modifMdp->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR);
                    $modifMdp->execute();
        }
    }

}
    $queryUser = $pdo->query("SELECT * FROM membre WHERE id_membre = '$_GET[id_membre]' ");
    $userActuel = $queryUser->fetch(PDO::FETCH_ASSOC);

    $id_membre = (isset($userActuel['id_membre'])) ? $userActuel['id_membre'] : "";
    $pseudo = (isset($userActuel['pseudo'])) ? $userActuel['pseudo'] : "";
    $nom = (isset($userActuel['nom'])) ? $userActuel['nom'] : "";
    $prenom = (isset($userActuel['prenom'])) ? $userActuel['prenom'] : "";
    $email = (isset($userActuel['email'])) ? $userActuel['email'] : "";
    
}




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


<?php if(isset($_GET['cible'])): ?>

<form class="my-5 offset-2 container" method="POST" action="">

    
    <input type="hidden" name="id_membre" value="<?= $id_membre ?>">
    <?php if($_GET['cible'] == 'profil'): ?>
    <div class="row">
        <div class="col-md-4 mt-5">
        <label class="form-label" for="pseudo"><div class="badge badge-dark text-dark">Pseudo</div></label>
        <input class="form-control" type="text" name="pseudo" value="<?= $pseudo ?>" id="pseudo"  placeholder="Pseudo">
        </div>

        <div class="col-md-4 mt-5">
        <label class="form-label" for="email"><div class="badge badge-dark text-dark">Email</div></label>
        <input class="form-control" type="email" name="email" value="<?= $email ?>" id="email"  placeholder="Email">
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mt-5">
        <label class="form-label" for="nom"><div class="badge badge-dark text-dark">Nom</div></label>
        <input class="form-control" type="text" name="nom" value="<?= $nom ?>" id="nom"  placeholder="Nom">
        </div>

        <div class="col-md-4 mt-5">
        <label class="form-label" for="prenom"><div class="badge badge-dark text-dark">Prénom</div></label>
        <input class="form-control" type="text" name="prenom"  value="<?= $prenom ?>" id="prenom"  placeholder="Prénom">
        </div>

        
        <?php else : ?>
        <div class="col-md-4 mt-5 offset-2">
            <label class="form-label" for="mdp"><div class="badge badge-dark text-dark">Mot de passe</div></label>
            <input class="form-control" type="password" name="mdp" id="mdp" placeholder="Mot de passe">
        </div>
        <?php endif ?>
    </div>


    <div class="col-md-1 mt-5 ">
    <button type="submit" class="btn btn-outline-dark offset-md-4 my-2">Valider</button>
    </div>

</form>
<?php endif ?>






<?php

require_once('./include/footer.php');
?>