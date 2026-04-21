<?php

//lignes pour afficher les erreurs.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once ROOT . '/config.php';

try{

    $bdd= new PDO("mysql:host=$host;dbname=$dbname",$user, $mdp);

}catch(PDOException $e){
    print "Erreur de connexion :".$e->getMessage()."<br>";
    die();
}



?>
