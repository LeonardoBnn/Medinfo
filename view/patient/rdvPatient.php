<?php
require_once ROOT . 'controller/rendez_vous/readRdvPatient.php';

function getStatusLabel($statut) {
    $labels = [
        'confirmé' => 'confirmé',
        'a_confirmer' => 'à confirmer',
        'annulé' => 'annulé',
        'honoré' => 'honoré'
    ];
    return $labels[$statut] ?? 'Inconnu';
}
// Le controller prépare déjà $rdvs via showRdvPatient()
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes rendez-vous - MedInfo</title>
</head>
<body>


<main class="medinfo-history-wrapper">
    <header class="medinfo-history-header">
        <h2>📋 Mes rendez-vous</h2>
        <p>Voici la liste de vos rendez-vous confirmés ou en attente.</p>
    </header>

    <div class="table-responsive">
        <table class="medinfo-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Médecin</th>
                    <th>Motif</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($rdvPatients)): ?>
                    <?php foreach ($rdvPatients as $rdv): ?>
                        <tr>
                            <td data-label="Date">
                                <div class="date-badge">
                                    <?= date('d/m/Y', strtotime($rdv['date_heure_debut'])); ?>
                                </div>
                            </td>
                            <td data-label="Heure">
                                <span class="text-muted"><?= date('H:i', strtotime($rdv['date_heure_debut'])); ?></span>
                            </td>
                            <td data-label="Médecin">
                                Dr. <?= htmlspecialchars($rdv['medecin_nom']); ?> <?= htmlspecialchars($rdv['medecin_prenom']); ?>
                            </td>
                            <td data-label="Motif">
                                <?= htmlspecialchars($rdv['motif']); ?>
                            </td>
                            <td data-label="Statut">
                                <span class="constante-tag">
                                    <?= htmlspecialchars(getStatusLabel($rdv['rdv_statut'])); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="empty-state">Vous n’avez aucun rendez-vous pour le moment.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

</body>
</html>
