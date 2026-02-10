<?php

try{

    $user='root';
    $mdp= '';

    $bdd= new PDO("mysql:host=localhost;dbname=medinfo",$user, $mdp);

}catch(PDOException $e){
    print "Erreur de connexion :".$e->getMessage()."<br>";
    die();
}



?>