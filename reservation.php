<?php
require_once('./include/init.php');

if(!internauteConnecteAdmin() || !internauteConnecte()){
    header('location:' . URL . 'connexion.php');
    exit();
}

require_once('./include/header.php');

?>









<?php
require_once('./include/footer.php');
?>