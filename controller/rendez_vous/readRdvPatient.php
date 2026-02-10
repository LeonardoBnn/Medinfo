<?php

require_once ROOT . 'model/rendez_vous/model.rdv.php';
require_once ROOT . 'bdd/bdd.php';

$readRdvPatients = new Rendez_vous($bdd);
$rdvPatients = $readRdvPatients->getAllRdvPatient($_SESSION['user']['id_utilisateur']);

?>