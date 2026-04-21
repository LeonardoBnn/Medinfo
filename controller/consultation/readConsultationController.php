<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once ROOT . '/bdd/bdd.php';
require_once ROOT . '/model/consultations/model.consultation.php';

$consultationController = new Consultation($bdd);

// On initialise des tableaux vides par défaut pour éviter des erreurs dans ta vue (HTML)
$consultationsMedecin = [];
$consultationsPatient = [];

// Si la session contient un ID de médecin, on charge les données du médecin
if (isset($_SESSION['user']['id_medecin'])) {
    $consultationsMedecin = $consultationController->getConsultationsMedecin($_SESSION['user']['id_medecin']);
}

// Si la session contient un ID de patient, on charge les données du patient
if (isset($_SESSION['user']['id_patient'])) {
    $consultationsPatient = $consultationController->getConsultationsPatient($_SESSION['user']['id_patient']);
}
?>
