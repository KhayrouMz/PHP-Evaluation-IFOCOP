<?php

$pdo = new PDO('mysql:host=localhost;dbname=lokisalle', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

session_start();



define('RACINE_SITE', $_SERVER['DOCUMENT_ROOT']. './php/lokisalle/');

define('URL', 'http://localhost/php/lokisalle/');



$erreur = "";
$validate = "";
$content = "";


foreach ($_POST as $key => $value){
    $_POST[$key] = htmlspecialchars(trim($value));
}


foreach ($_GET as $key => $value){
    $_GET[$key] = htmlspecialchars(trim($value));
}



require_once('fonctions.php');
?>