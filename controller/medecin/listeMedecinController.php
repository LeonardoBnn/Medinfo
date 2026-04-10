<?php
include_once ROOT . 'model/medecin/model.medecin.php';
include_once ROOT . 'bdd/bdd.php';

$medecinModel = new Medecin($bdd);

// 1. Récupérer tous les médecins
$medecins = $medecinModel->readMedecin();

// 2. Récupérer les spécialités pour le filtre
$req = $bdd->query("SELECT * FROM specialite");
$specialites = $req->fetchAll(PDO::FETCH_ASSOC);

// 3. Appliquer le filtre si l'utilisateur a choisi une spécialité
if (isset($_GET['specialite']) && !empty($_GET['specialite'])) {
    $id_spe_recherche = (int)$_GET['specialite'];
    
    // On filtre le tableau des médecins
    $medecins = array_filter($medecins, function($m) use ($id_spe_recherche) {
        return $m['fk_id_specialite'] == $id_spe_recherche;
    });
}
?>