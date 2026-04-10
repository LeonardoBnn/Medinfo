<?php require_once ROOT . 'controller/medecin/listeMedecinController.php'; ?>

<main class="main-section" style="max-width: 1000px; margin: 0 auto;">
    <h2>🩺 L'équipe médicale MedInfo</h2>
    <p>Découvrez nos praticiens et prenez rendez-vous en quelques clics.</p>

    <form method="GET" action="index.php" class="rdv-filter-form" style="justify-content: center; margin-bottom: 2rem;">
        <input type="hidden" name="page" value="listeMedecins"> 
        
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
        <button type="submit" class="btn-secondary">Rechercher</button>
    </form>

    <div class="doctors-grid">
        <?php if (!empty($medecins)): ?>
            <?php foreach ($medecins as $m): ?>
                <div class="doctor-card">
                    <h4>Dr. <?= htmlspecialchars($m['nom'] . ' ' . $m['prenom']) ?></h4>
                    <p class="specialty"><?= htmlspecialchars($m['specialite'] ?? 'Spécialité non définie') ?></p>
                    
                    <p style="font-size: 0.9rem; color: var(--medinfo-text-muted); margin: 0.5rem 0;">
                        <?= htmlspecialchars($m['description'] ?? '') ?>
                    </p>
                    
                    <p class="languages"><small>🗣️ <?= htmlspecialchars($m['langues_parlees'] ?? 'Non renseigné') ?></small></p>
                    
                    <?php if(!empty($_SESSION['user'])){ ?>
                    <a href="index.php?page=prendreRdv&step=2&id_medecin=<?= $m['id_medecin'] ?>" class="btn-primary" style="margin-top: 1rem;">Prendre RDV</a>
                    <?php } ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun médecin trouvé pour cette recherche.</p>
        <?php endif; ?>
    </div>
</main>