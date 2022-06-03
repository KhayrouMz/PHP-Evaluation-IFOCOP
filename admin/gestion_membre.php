<?php
require_once('../include/init.php');

if(!internauteConnecteAdmin()){
    header('location:' . URL . 'connexion.php');
    exit();
}


if(isset($_GET['action'])){
    if($_POST){
        if(!isset($_POST['pseudo']) || !preg_match('#^[a-zA-Z0-9-_.]{3,20}$#', $_POST['pseudo'])){
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format pseudo !</div>';
        }
        if($_GET['action'] == "add"){
            $verifPseudo = $pdo->prepare("SELECT pseudo FROM membre WHERE pseudo = :pseudo ");
            $verifPseudo->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
            $verifPseudo->execute();
            if($verifPseudo->rowCount() == 1){
                $erreur .= '<div class="alert alert-danger" role="alert">Erreur ce pseudo n\'est pas disponible !</div>';
            }
            if(!isset($_POST['mdp']) || strlen($_POST['mdp']) < 3 || strlen($_POST['mdp']) > 20){
                $erreur .= '<div class="alert alert-danger" role="alert">Erreur format mot de passe !</div>';
            }

            $_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
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
        if(empty($erreur)){
            if($_GET['action'] == "update"){
                $modifUser = $pdo->prepare("UPDATE membre SET id_membre = :id_membre , pseudo = :pseudo , nom = :nom , prenom = :prenom , email = :email , civilite = :civilite WHERE id_membre = :id_membre ");
                $modifUser->bindValue(':id_membre', $_POST['id_membre'], PDO::PARAM_INT);
                $modifUser->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
                $modifUser->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
                $modifUser->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
                $modifUser->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
                $modifUser->bindValue(':civilite', $_POST['civilite'], PDO::PARAM_STR);
                $modifUser->execute();

                $queryUser = $pdo->query("SELECT pseudo FROM membre WHERE id_membre = '$_GET[id_membre] ' ");

                $user = $queryUser->fetch(PDO::FETCH_ASSOC);

                $content .= '<div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
                        <strong>Félicitations !</strong> modification du user ' . $user['pseudo'] . ' réussie !
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            }else{

                $inscrireUser = $pdo->prepare("INSERT INTO membre(pseudo, mdp, nom, prenom, email, civilite, date_enregistrement) VALUES (:pseudo, :mdp, :nom, :prenom, :email, :civilite, NOW())");
                $inscrireUser->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
                $inscrireUser->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR);
                $inscrireUser->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
                $inscrireUser->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
                $inscrireUser->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
                $inscrireUser->bindValue(':civilite', $_POST['civilite'], PDO::PARAM_STR);

                $inscrireUser->execute();

                $content .= '<div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
                        <strong>Félicitations !</strong> Ajout du user réussie !
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            }
        }
    }


    if($_GET['action'] == 'update'){

        $queryUser = $pdo->query("SELECT * FROM membre WHERE id_membre = '$_GET[id_membre]' ");
        $userActuel = $queryUser->fetch(PDO::FETCH_ASSOC);
    }

    $id_membre = (isset($userActuel['id_membre'])) ? $userActuel['id_membre'] : "";
    $pseudo = (isset($userActuel['pseudo'])) ? $userActuel['pseudo'] : "";
    $nom = (isset($userActuel['nom'])) ? $userActuel['nom'] : "";
    $prenom = (isset($userActuel['prenom'])) ? $userActuel['prenom'] : "";
    $email = (isset($userActuel['email'])) ? $userActuel['email'] : "";
    $civilite = (isset($userActuel['civilite'])) ? $userActuel['civilite'] : "";
    
    if($_GET['action'] == 'delete'){

        $pdo->query("DELETE FROM membre WHERE id_membre = '$_GET[id_membre]'");
    }
}

require_once('includeAdmin/header.php');
?>

<h1 class="text-center my-5"><div class="badge badge-warning text-dark p-3">Gestion des utilisateurs</div></h1>

<?= $erreur ?>
<?= $content ?>

<?php if(isset($_GET['action'])): ?>

<h2 class="my-5">Formulaire <?= ($_GET['action'] == 'add') ? "d'ajout" : "de modification" ?> des utilisateurs</h2>

<form class="my-5" method="POST" action="">

    
    <input type="hidden" name="id_membre" value="<?= $id_membre ?>">

    <div class="row">
        <div class="col-md-4 mt-5">
        <label class="form-label" for="pseudo"><div class="badge badge-dark text-wrap">Pseudo</div></label>
        <input class="form-control" type="text" name="pseudo" value="<?= $pseudo ?>" id="pseudo"  placeholder="Pseudo">
        </div>

        
        <?php if($_GET['action'] == 'add'): ?>
        <div class="col-md-4 mt-5">
        <label class="form-label" for="mdp"><div class="badge badge-dark text-wrap">Mot de passe</div></label>
        <input class="form-control" type="password" name="mdp" id="mdp" placeholder="Mot de passe">
        </div>
        <?php endif ?>
        
        
        <div class="col-md-4 mt-5">
        <label class="form-label" for="email"><div class="badge badge-dark text-wrap">Email</div></label>
        <input class="form-control" type="email" name="email" value="<?= $email ?>" id="email"  placeholder="Email">
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mt-5">
        <label class="form-label" for="nom"><div class="badge badge-dark text-wrap">Nom</div></label>
        <input class="form-control" type="text" name="nom" value="<?= $nom ?>" id="nom"  placeholder="Nom">
        </div>

        <div class="col-md-4 mt-5">
        <label class="form-label" for="prenom"><div class="badge badge-dark text-wrap">Prénom</div></label>
        <input class="form-control" type="text" name="prenom"  value="<?= $prenom ?>" id="prenom"  placeholder="Prénom">
        </div>

        <div class="col-md-4 mt-4">
            <p><div class="badge badge-dark text-wrap">Civilité</div></p>

            <input type="radio" name="civilite" id="civilite1" value="f" <?= ($civilite  == 'f') ? 'checked' : '' ?> >
            <label class="mx-2" for="civilite1">Femme</label>

            <input type="radio" name="civilite" id="civilite2" value="m" <?= ($civilite  == 'm') ? 'checked' : '' ?>>
            <label class="mx-2" for="civilite2">Homme</label>
        </div>
    </div>


    <div class="col-md-1 mt-5 ">
    <button type="submit" class="btn btn-outline-dark offset-md-4 my-2">Valider</button>
    </div>

</form>
<?php endif ?>
<?php $queryUsers = $pdo->query("SELECT id_membre FROM membre ") ?>
<h2 class="py-5">Nombre de users en base de données: <?= $queryUsers->rowCount() ?></h2>

<div class="d-flex justify-content-center align-items-center py-5">
    <a href='?action=add'>
        <button type="button" class="btn btn-sm btn-outline-dark shadow rounded">
        <i class="bi bi-plus-circle-fill"></i> Ajouter un utilisateur
        </button>
    </a>
</div>

<table class="table text-center">
    <?php $afficheUsers = $pdo->query("SELECT * FROM membre ORDER BY pseudo ASC ") ?>
    <thead>
        <tr>
            <?php for($i = 0; $i < $afficheUsers-> columnCount(); $i++){
                $colonne = $afficheUsers->getColumnMeta($i);
                if($colonne['name'] != 'mdp'){ ?>
            <th><?= $colonne['name'] ?></th>
            <?php }
            } ?>
            <th colspan='2'>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while($user = $afficheUsers->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <?php foreach($user as $key => $value){
                if($key != 'mdp'){ ?>
            <td><?= $value ?></td>
            <?php }
            } ?>
            <td><a href='?action=update&id_membre=<?= $user['id_membre'] ?>'><i class="bi bi-pencil-square text-dark" style="font-size: 1.5rem;"></i></a></td>
            <td><a data-href="?action=delete&id_membre=<?= $user['id_membre'] ?>" data-toggle="modal" data-target="#confirm-delete"><i class="bi bi-trash text-danger" style="font-size: 1.5rem;"></i></a></td>
        </tr>
        <?php endwhile ?>
    </tbody>
</table>

<!-- modal suppression codepen https://codepen.io/lowpez/pen/rvXbJq -->

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Supprimer Utilisateur
            </div>
            <div class="modal-body">
                Etes-vous sur de vouloir retirer cet utilisateur de votre base de données ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
                <a class="btn btn-danger btn-ok">Supprimer</a>
            </div>
        </div>
    </div>
</div>

<?php require_once('includeAdmin/footer.php');