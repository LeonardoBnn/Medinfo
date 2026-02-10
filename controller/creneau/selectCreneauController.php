<?php
include('model/rendez_vous/model.rdv.php');
include('bdd/bdd.php');

$rdv = new Rendez_vous($bdd);
$creneaux = $rdv->allCreneaux();
