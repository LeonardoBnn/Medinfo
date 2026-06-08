<?php

require_once ROOT . 'model/rendez_vous/model.rdv.php';
require_once ROOT . 'bdd/bdd.php';

$readRdvMedecins = new Rendez_vous($bdd);

// CORRECTION : On utilise la nouvelle méthode et on renomme la variable en $rdvMedecins
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