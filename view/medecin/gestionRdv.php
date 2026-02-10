<?php
// -------------------------------------------------------------------
// PARTIE 1 : SIMULATION DES DONNÉES (À remplacer par ta requête SQL)
// -------------------------------------------------------------------
$rendezVousList = [
    [
        'id' => 101,
        'heure' => '09:00',
        'patient' => 'Jean Dupont',
        'email' => 'jean.dupont@email.com',
        'motif' => 'Suivi cardiologique',
        'statut' => 'a_confirmer',
        'type' => 'Consultation'
    ],
    [
        'id' => 102,
        'heure' => '10:30',
        'patient' => 'Sophie Martin',
        'email' => 's.martin@test.fr',
        'motif' => 'Vaccination grippe',
        'statut' => 'confirme',
        'type' => 'Soins infirmiers'
    ],
    [
        'id' => 103,
        'heure' => '11:15',
        'patient' => 'Marc Alibert',
        'email' => 'm.alibert@domaine.com',
        'motif' => 'Douleurs abdominales',
        'statut' => 'annule',
        'type' => 'Urgence'
    ],
    [
        'id' => 104,
        'heure' => '14:00',
        'patient' => 'Lucie Bernard',
        'email' => 'lucie.b@email.com',
        'motif' => 'Renouvellement ordonnance',
        'statut' => 'honore',
        'type' => 'Consultation'
    ]
];

// Fonction utilitaire pour le style des badges (basé sur styles.agenda.css)
function getStatusClass($statut) {
    switch ($statut) {
        case 'confirme': return 'rdv-status--confirmé';
        case 'a_confirmer': return 'rdv-status--a_confirmer';
        case 'annule': return 'rdv-status--annulé';
        case 'honore': return 'rdv-status--honoré';
        default: return 'rdv-status--absent';
    }
}

// Fonction pour l'affichage propre du texte
function getStatusLabel($statut) {
    $labels = [
        'confirme' => 'Confirmé',
        'a_confirmer' => 'À Confirmer',
        'annule' => 'Annulé',
        'honore' => 'Honoré'
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
                        <?php foreach ($rendezVousList as $rdv): ?>
                        <tr>
                            <td data-label="Heure">
                                <div class="date-badge">
                                    <span><?php echo $rdv['heure']; ?></span>
                                </div>  
                            </td>

                            <td data-label="Patient">
                                <span style="font-weight: 600; color: var(--medinfo-primary);">
                                    <?php echo htmlspecialchars($rdv['patient']); ?>
                                </span>
                            </td>

                            <td data-label="Motif">
                                <span class="text-muted motif-wrapper">
                                    <span class="material-symbols-outlined"></span>
                                    <?php echo htmlspecialchars($rdv['motif']); ?>
                                </span>
                            </td>

                            <td data-label="Contact">
                                <a href="mailto:<?php echo $rdv['email']; ?>?subject=Rappel de Rendez-vous - MedInfo" 
                                   class="btn-icon btn-contact" 
                                   title="Envoyer un email à <?php echo htmlspecialchars($rdv['patient']); ?>">
                                    <span class="material-symbols-outlined">mail</span>
                                </a>
                            </td>

                            <td data-label="Statut">
                                <span class="rdv-status <?php echo getStatusClass($rdv['statut']); ?>">
                                    <?php echo getStatusLabel($rdv['statut']); ?>
                                </span>
                            </td>

                            <td data-label="Actions">
                                <div class="action-btn-group">
                                    <?php if ($rdv['statut'] === 'a_confirmer'): ?>
                                        <a href="actions_rdv.php?action=confirmer&id=<?php echo $rdv['id']; ?>" 
                                           class="btn-icon btn-confirm" title="Confirmer">
                                            <span class="material-symbols-outlined">check</span>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($rdv['statut'] !== 'annule' && $rdv['statut'] !== 'honore'): ?>
                                        <a href="actions_rdv.php?action=honorer&id=<?php echo $rdv['id']; ?>" 
                                           class="btn-icon btn-honor" title="Marquer comme honoré">
                                            <span class="material-symbols-outlined">assignment_turned_in</span>
                                        </a>
                                        
                                        <a href="actions_rdv.php?action=annuler&id=<?php echo $rdv['id']; ?>" 
                                           class="btn-icon btn-cancel" title="Annuler">
                                            <span class="material-symbols-outlined">close</span>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <a href="details_rdv.php?id=<?php echo $rdv['id']; ?>" 
                                       class="btn-icon" title="Voir détails">
                                        <span class="material-symbols-outlined">visibility</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>