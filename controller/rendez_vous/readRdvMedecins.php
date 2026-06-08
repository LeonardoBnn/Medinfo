<?php

require_once ROOT . 'model/rendez_vous/model.rdv.php';
require_once ROOT . 'bdd/bdd.php';

$readRdvMedecins = new Rendez_vous($bdd);

// 1. Pour la page "Gestion des Rendez-vous" (Historique complet)
$rendezVousList = $readRdvMedecins->getAllRdvMedecin($_SESSION['user']['id_utilisateur']);

// 2. Pour la page "Accueil Médecin" (Agenda du jour uniquement)
$rdvMedecins = $readRdvMedecins->getTodayRdvMedecin($_SESSION['user']['id_utilisateur']);

$formatter = new IntlDateFormatter(
    'fr_FR',
    IntlDateFormatter::LONG,
    IntlDateFormatter::NONE,
    'Europe/Paris',
    IntlDateFormatter::GREGORIAN,
    'EEEE d MMMM yyyy'
);

?>