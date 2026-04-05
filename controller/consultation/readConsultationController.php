<?php

require_once ROOT . 'bdd/bdd.php';
require_once ROOT . 'model/consultations/model.consultation.php';

$consultationController = new Consultation($bdd);

$consultationsMedecin = $consultationController->getConsultationsMedecin($_SESSION['user']['id_medecin']);

$consultationsPatient = $consultationController->getConsultationsPatient($_SESSION['user']['id_patient']);

?>