<?php
require_once('include/init.php');


if(isset($_GET['action']) && $_GET['action'] == "deconnexion"){
    unset($_SESSION['membre']);
    header('location:'.URL.'connexion.php');
    exit();
}


if (internauteConnecte()){
    header('location:'.URL.'profil.php');
}

if ($_POST){
    $verifUser = $pdo->prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
    $verifUser->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
    $verifUser->execute();
        if ($verifUser->rowCount() == 1){
            $user = $verifUser->fetch(PDO::FETCH_ASSOC);
            if (password_verify($_POST['mdp'], $user['mdp'])){
                foreach ($user as $key => $value){
                    
                    if ($key != 'mdp'){
                        $_SESSION['membre'][$key] = $value;
                        if (internauteConnecteAdmin()){
                            header('location:'.URL.'admin/index.php?action=validate');
                        }else{
                            header('location:'.URL.'profil.php?action=validate');
                        }
                    }
                }
            }else{
                $erreur .= '<div class="alert alert-danger" role="alert">Erreur ce mot de passe n\'existe pas !</div>';
            }
    }else{
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur ce pseudo n\'existe pas !</div>';
    }
}


require_once('./include/header.php');
?>




<h2 class="text-center py-5">Connexion</h2>

<?= $erreur ?>

<!--  -->

<form class="my-5" method="POST" action="">

    <div class="col-md-4 offset-md-4 my-4">

    <label class="form-label" for="pseudo">Pseudo</label>
    <input class="form-control mb-4" type="text" name="pseudo" id="pseudo" placeholder="Votre pseudo">

    <label class="form-label" for="mdp">Mot de passe</label>
    <input class="form-control mb-4" type="password" name="mdp" id="mdp" placeholder="Votre mot de passe">

    <button type="submit" class="btn btn-outline-dark offset-md-4 my-2">Connexion</button>

    </div>
</form>




<?php require_once('./include/footer.php') ?>