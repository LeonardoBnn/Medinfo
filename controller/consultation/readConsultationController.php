<?php

require_once ROOT . 'bdd/bdd.php';
require_once ROOT . 'model/consultations/model.consultation.php';

$consultationController = new Consultation($bdd);

$consultations = $consultationController->getConsultationsMedecin($_SESSION['user']['id_medecin']);

?>