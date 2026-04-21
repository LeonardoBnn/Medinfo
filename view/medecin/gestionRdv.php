<?php

require_once ROOT . 'controller/rendez_vous/readRdvMedecins.php';
//var_dump($rendezVousList);
//die();

// Fonction utilitaire pour le style des badges (basé sur styles.agenda.css)
function getStatusClass($statut) {
    switch ($statut) {
        case 'confirmé': return 'rdv-status--confirmé';
        case 'a_confirmer': return 'rdv-status--a_confirmer';
        case 'annulé': return 'rdv-status--annulé';
        case 'honoré': return 'rdv-status--honoré';
        default: return 'rdv-status--absent';
    }
}

// Fonction pour l'affichage propre du texte
function getStatusLabel($statut) {
    $labels = [
        'confirmé' => 'confirmé',
        'a_confirmer' => 'à confirmer',
        'annulé' => 'annulé',
        'honoré' => 'honoré'
    ];
    return $labels[$statut] ?? 'Inconnu';
}
?>
    <div class="medinfo-history-wrapper">
        
        <div class="medinfo-history-header">
            <h2>Gestion des Rendez-vous</h2>
            <p>Gérez vos rendez-vous, contactez vos patients et confirmez les demandes.</p>
        </div>

        <div class="table-responsive">
            <table class="medinfo-table">
                <thead>
                    <tr>
                        <th width="8%">Heure</th>
                        <th width="17%">Patient</th>
                        <th width="25%">Motif</th>
                        <th width="10%">Contact</th>
                        <th width="15%">Statut</th>
                        <th width="25%" style="text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($rendezVousList)): ?>
                        <tr>
                            <td colspan="6" class="empty-state">Aucun rendez-vous prévu.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($rendezVousList as $rdv):
				//var_dump($rdv['patient_email']);
				//die();			 ?>
                        <tr>
                            <td data-label="Heure">
                                <div class="date-badge">
                                    <span><?php echo $rdv['heure_debut_formatee']; ?></span>
                                </div>  
                            </td>

                            <td data-label="Patient">
                                <span style="font-weight: 600; color: var(--medinfo-primary);">
                                    <?php echo htmlspecialchars($rdv['patient_prenom'] ." ". $rdv['patient_nom']); ?>
                                </span>
                            </td>

                            <td data-label="Motif">
                                <span class="text-muted motif-wrapper">
                                    <span class="material-symbols-outlined"></span>
                                    <?php echo htmlspecialchars($rdv['motif']); ?>
                                </span>
                            </td>

                            <td data-label="Contact">
                                <a href="mailto:<?php echo $rdv['patient_email']; ?>?subject=Rappel de Rendez-vous - MedInfo" 
                                   class="btn-icon btn-contact" 
                                   title="Envoyer un email à <?php echo htmlspecialchars($rdv['patient_email']); ?>">
                                    <span class="material-symbols-outlined">mail</span>
                                </a>
                            </td>

                            <td data-label="Statut">
                                <?php //var_dump($rdv['rdv_statut']); ?>
                                <span class="rdv-status <?php echo getStatusClass($rdv['rdv_statut']); ?>">
                                    <?php echo getStatusLabel($rdv['rdv_statut']); ?>
                                </span>
                            </td>

                            <td data-label="Actions">
                                <div class="action-btn-group">
                                    <?php if ($rdv['rdv_statut'] === 'a_confirmer'): ?>
                                        <a href="index.php?page=controllerRdv&action=confirmé&id_rdv=<?php echo $rdv['id_rdv']; ?>" 
                                           class="btn-icon btn-confirm" title="Confirmer">
                                            <span class="material-symbols-outlined">check</span>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($rdv['rdv_statut'] !== 'annulé' && $rdv['rdv_statut'] !== 'honoré'): ?>
                                        <a href="index.php?page=controllerRdv&action=honoré&id_rdv=<?php echo $rdv['id_rdv']; ?>" 
                                           class="btn-icon btn-honor" title="Marquer comme honoré">
                                            <span class="material-symbols-outlined">assignment_turned_in</span>
                                        </a>
                                        
                                        <a href="index.php?page=controllerRdv&action=annulé&id_rdv=<?php echo $rdv['id_rdv']; ?>" 
                                           class="btn-icon btn-cancel" title="Annuler">
                                            <span class="material-symbols-outlined">close</span>
                                        </a>
                                    <?php endif; ?>
                                    <!--
                                    <a href="index.php?page=controllerRdv&id_rdv=<?php echo $rdv['id_rdv']; ?>" 
                                       class="btn-icon" title="Voir détails">
                                        <span class="material-symbols-outlined">visibility</span>
                                    </a>
                                    -->
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
