<?php
require_once ROOT . 'controller/rendez_vous/readRdvPatient.php';

// Le controller prépare déjà $rdvs via showRdvPatient()
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes rendez-vous - MedInfo</title>
</head>
<body>

<main class="rdv-container">
    <section class="rdv-section">
        <h2>📋 Mes rendez-vous</h2>
        <p>Voici la liste de vos rendez-vous confirmés ou en attente.</p>

        <table class="rdv-table">
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
                            <td><?= date('d/m/Y', strtotime($rdv['date_heure_debut'])); ?></td>
                            <td><?= date('H:i', strtotime($rdv['date_heure_debut'])); ?></td>
                            <td>Dr. <?= htmlspecialchars($rdv['medecin_nom']); ?> <?= htmlspecialchars($rdv['medecin_prenom']); ?></td>
                            <td><?= htmlspecialchars($rdv['motif']); ?></td>
                            <td><?= htmlspecialchars($rdv['rdv_statut']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5">Vous n’avez aucun rendez-vous pour le moment.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

</body>
</html>
