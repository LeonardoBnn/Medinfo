<?php
require_once ROOT . 'controller/rendez_vous/readRdvMedecins.php';
//var_dump($rdvMedecins);
//die();
?>

<div class="medinfo-agenda-section">
    <div class="medinfo-agenda-header">
        <h2>🗓️ Mon Agenda du Jour</h2>
        <p class="medinfo-agenda-date">Mardi 10 Décembre 2025</p>
    </div>

    <div class="medinfo-rdv-list">
        <!-- si le médecin a des rdv alors on les affiches -->
        <?php if (!empty($rdvMedecins)): ?>
            <?php foreach ($rdvMedecins as $rdv): ?>
                <div class="medinfo-rdv-card medinfo-rdv-card--<?= $rdv['rdv_statut'] ?>" data-rdv-id="<?= $rdv['id_rdv'] ?>">
                    <div class="rdv-card-time-status">
                        <span class="rdv-time"><?= $rdv['heure_debut_formatee'] ?></span>
                        <span class="rdv-status rdv-status--<?= $rdv['rdv_statut'] ?>">
                <!--On attribue à chaque rdv une version mieux lisible du statut-->
                            <?= match($rdv['rdv_statut']) {
                                'confirmé' => 'Confirmé',
                                'a_confirmer' => 'À confirmer',
                                'annulé' => 'Annulé',
                                'honoré' => 'Honoré',
                                'absent' => 'Absent'
                            } ?>
                        </span>
                    </div>

                    <div class="rdv-card-details">
                        <p class="rdv-patient-name">
                            <i class="fas fa-user-circle"></i> 
                            <?= $rdv['patient_prenom'] ?> <strong><?= $rdv['patient_nom'] ?></strong>
                        </p>
                        <p class="rdv-motif">
                            <i class="fas fa-clipboard-list"></i>
                            <?= $rdv['motif'] ?>
                        </p>
                        <p class="rdv-location">
                            <i class="fas fa-hospital"></i> 
                            <?= $rdv['salle_libelle'] ?>
                        </p>
                    </div>

                    <div class="rdv-card-actions">
                        <button class="medinfo-btn-ghost rdv-action-detail"><a href="index.php?page=ajouterConsultation&id_patient=<?php echo $rdv['id_patient']?>">Démarrer</a></button>
                        <?php if ($rdv['rdv_statut'] === 'a_confirmer'): ?>
                            <button class="medinfo-btn-primary-nav rdv-action-confirm"><a href="index.php?page=controllerRdv"> Confirmer</a></button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- sinon on affiche ce message -->
            <p class="medinfo-no-rdv">Aucun rendez-vous planifié pour aujourd'hui. Profitez-en !</p>
        <?php endif; ?>
    </div>
</div>