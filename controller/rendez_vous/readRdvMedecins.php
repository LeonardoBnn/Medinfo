<?php

require_once ROOT . 'model/rendez_vous/model.rdv.php';
require_once ROOT . 'bdd/bdd.php';

$readRdvMedecins = new Rendez_vous($bdd);
$rdvMedecins = $readRdvMedecins->getAllRdvMedecin($_SESSION['user']['id_utilisateur']);

?>