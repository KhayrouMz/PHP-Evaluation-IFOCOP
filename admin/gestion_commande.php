<?php

require_once('../include/init.php');

if(!internauteConnecteAdmin()){
    header('location:' . URL . 'connexion.php');
    exit();
}

require_once('includeAdmin/header.php');
?>



<table class="table text-center">
    <?php $afficheUsers = $pdo->query("SELECT * FROM commande ORDER BY id_commande ASC ") ?>
    <thead>
        <tr>
            <?php for($i = 0; $i < $afficheUsers-> columnCount(); $i++){
                $colonne = $afficheUsers->getColumnMeta($i);
                if($colonne['name'] != 'mdp'){ ?>
            <th><?= $colonne['name'] ?></th>
            <?php }
            } ?>
            <th colspan='1'>Actions</th>
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
            <td><a href="?action=delete&id_commande=<?= $user['id_commande'] ?>" data-toggle="modal" data-target="#confirm-delete"><i class="bi bi-trash text-danger" style="font-size: 1.5rem;"></i></a></td>
        </tr>
        <?php endwhile ?>
    </tbody>
</table>







<?php require_once('includeAdmin/footer.php'); ?>