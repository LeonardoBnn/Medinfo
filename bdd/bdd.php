<?php

require_once ROOT . '/config.php';

try{

    $bdd= new PDO("mysql:host=$host;dbname=$dbname",$user, $mdp);

}catch(PDOException $e){
    print "Erreur de connexion :".$e->getMessage()."<br>";
    die();
}



?>