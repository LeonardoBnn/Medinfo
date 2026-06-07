<?php

  // Si le routeur gère mal la portée des variables, "global" permet de les récupérer
  global $step, $medecins, $creneaux, $specialites, $recapInfo;
  require_once ROOT . 'controller/creneau/selectCreneauController.php'; 

  // Dernière sécurité si le contrôleur n'a pas pu charger la variable
  if (!isset($step)) { $step = 1; }
?>

<main class="rdv-container">
  <section class="rdv-section">
    
    <div class="rdv-steps-indicator">
        <span class="<?= $step >= 1 ? 'active' : '' ?>">1. Médecin</span> > 
        <span class="<?= $step >= 2 ? 'active' : '' ?>">2. Date & Heure</span> > 
        <span class="<?= $step == 3 ? 'active' : '' ?>">3. Confirmation</span>
    </div>

    <?php if ($step == 1): ?>
        <h2>Choisissez un praticien</h2>
        
        <form method="GET" action="index.php" class="rdv-filter-form">
            <input type="hidden" name="page" value="prendreRdv">
            <select name="specialite">
                <option value="">Toutes les spécialités</option>
                <?php if (!empty($specialites)): ?>
                    <?php foreach($specialites as $spe): ?>
                        <option value="<?= $spe['id_specialite'] ?>" <?= (isset($_GET['specialite']) && $_GET['specialite'] == $spe['id_specialite']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($spe['libelle']) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <button type="submit" class="btn-secondary">Filtrer</button>
        </form>

        <div class="doctors-grid">
            <?php if (!empty($medecins)): ?>
                <?php foreach ($medecins as $m): ?>
                    <div class="doctor-card">
                        <h4>Dr. <?= htmlspecialchars($m['nom'] . ' ' . $m['prenom']) ?></h4>
                        <p class="specialty"><?= htmlspecialchars($m['specialite'] ?? 'Spécialité non définie') ?></p>
                        <p class="languages"><small>🗣️ <?= htmlspecialchars($m['langues_parlees'] ?? 'Non renseigné') ?></small></p>
                        <a href="index.php?page=prendreRdv&step=2&id_medecin=<?= $m['id_medecin'] ?>" class="btn-primary">Je choisis ce médecin</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun médecin trouvé pour cette spécialité.</p>
            <?php endif; ?>
        </div>

    <?php elseif ($step == 2): ?>
        <h2>Choisissez une date et une heure</h2>
        <a href="index.php?page=prendreRdv&step=1" class="back-link">← Retour aux médecins</a>

        <form method="GET" action="index.php" class="rdv-filter-form" style="margin-top: 1rem;">
            <input type="hidden" name="page" value="prendreRdv">
            <input type="hidden" name="step" value="2">
            <input type="hidden" name="id_medecin" value="<?= htmlspecialchars($_GET['id_medecin'] ?? 0) ?>">
            
            <label>Filtrer par date :</label>
            <input type="date" name="date_choisie" value="<?= htmlspecialchars($_GET['date_choisie'] ?? '') ?>">
            <button type="submit" class="btn-secondary">Rechercher</button>
        </form>

        <div class="slots-grid">
            <?php if (!empty($creneaux)): ?>
                <?php foreach ($creneaux as $c): ?>
                    <a href="index.php?page=prendreRdv&step=3&id_creneau=<?= $c['id_creneau'] ?>" class="slot-btn">
                        <strong><?= date('H:i', strtotime($c['date_heure_debut'])); ?></strong><br>
                        <small><?= date('d/m/Y', strtotime($c['date_heure_debut'])); ?></small>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun créneau disponible pour le moment (ou aucune date sélectionnée).</p>
            <?php endif; ?>
        </div>

    <?php elseif ($step == 3): ?>
        <h2>Finaliser votre rendez-vous</h2>
        <a href="javascript:history.back()" class="back-link">← Retour aux créneaux</a>

        <?php if (!empty($recapInfo)): ?>
            <div class="rdv-recap">
                <p>Vous prenez rendez-vous avec le <strong>Dr. <?= htmlspecialchars($recapInfo['medecin_nom'] . ' ' . $recapInfo['medecin_prenom']) ?></strong>.</p>
                <p>Le <strong><?= date('d/m/Y à H:i', strtotime($recapInfo['date_heure_debut'])) ?></strong>.</p>
            </div>
        <?php endif; ?>

        <form action="index.php?page=controllerRdv" method="POST" class="rdv-form">
            <div class="rdv-form-group">
                <label for="motif">Motif du rendez-vous (250 caractères max) <span class="required">*</span></label>
                <textarea id="motif" name="motif" required placeholder="Ex: Consultation de suivi..." maxlength="250" rows="4"></textarea>
            </div>

            <input type="hidden" name="origine" value="Plateforme en ligne">
            <input type="hidden" name="id_patient" value="<?= $_SESSION['user']['id_patient'] ?? 0; ?>">
            <input type="hidden" name="id_creneau" value="<?= htmlspecialchars($_GET['id_creneau'] ?? 0); ?>">
            <input type="hidden" name="action" value="ajouter">
            <input type="hidden" name="statut" value="occupe">

            <div class="rdv-form-actions">
                <button type="submit" class="btn-primary">Confirmer le RDV</button>
            </div>
        </form>
    <?php endif; ?>

  </section>
</main>