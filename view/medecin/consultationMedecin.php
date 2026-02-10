<?php
require_once ROOT . 'controller/consultation/readConsultationController.php';
//var_dump($consultations);
//die();
?>

<div class="medinfo-history-wrapper">
    <div class="medinfo-history-header">
        <h2>Historique des Consultations</h2>
        <p>Retrouvez ci-dessous les derniers examens réalisés.</p>
    </div>

    <div class="table-responsive">
        <table class="medinfo-table">
            <thead>
                <tr>
                    <th>Date & Heure</th>
                    <th>Patient</th>
                    <th>Compte Rendu</th>
                    <th>Tension/Poids</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($consultations as $consultation): ?>
                <tr>
                    <td data-label="Date & Heure">
                        <span class="date-badge">
                            <?php echo $consultation['date']; ?> <small>à <?php echo $consultation['heure']; ?></small>
                        </span>
                    </td>
                    <td data-label="Patient">
                        <strong><?php echo $consultation['nom']." ".$consultation['prenom']; ?></strong>
                    </td>
                    <td data-label="Motif" class="text-muted">
                        <?php echo $consultation['compte_rendu']; ?>
                    </td>
                    <td data-label="Constantes">
                        <span class="constante-tag"><?php echo $consultation['tension']; ?></span>
                        <span class="constante-tag"><?php echo $consultation['poids']; ?></span>
                    </td>
                    <td data-label="Actions" style="text-align: right;">
                        <a href="#" class="btn-table-action">Voir fiche</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?php if (empty($consultations)): ?>
        <div class="empty-state">Aucune consultation enregistrée pour le moment.</div>
    <?php endif; ?>
</div>