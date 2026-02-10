<?php 
require_once ROOT . 'controller/creneau/selectCreneauController.php'; 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Prendre un rendez-vous - MedInfo</title>
    <link rel="stylesheet" href="public/css/styles.rdv.css"> <!-- adapte ce chemin -->
</head>
<body>

<main class="rdv-container">
  <section class="rdv-section">
    <h2>📅 Prendre un rendez-vous</h2>

    <form action="index.php?page=rdvPatient" method="POST" class="rdv-form">
      <div class="rdv-form-group">
        <label for="id_creneau">Créneau disponible <span class="required">*</span></label>
        <select id="id_creneau" name="id_creneau" required>
          <option value="">-- Sélectionnez un créneau --</option>
          <?php foreach ($creneaux as $c) { ?>
            <option value="<?= $c['id_creneau']; ?>">
              <?= date('d/m/Y H:i', strtotime($c['date_heure_debut'])); ?> 
              avec Dr. <?= $c['medecin_nom']; ?> <?= $c['medecin_prenom']; ?>
            </option>
          <?php } ?>
        </select>
      </div>

      <div class="rdv-form-group">
        <label for="motif">Motif du rendez-vous <span class="required">*</span></label>
        <textarea id="motif" name="motif" required placeholder="Motif du rendez-vous"></textarea>
      </div>

      <input type="hidden" name="origine" value="patient">
      <input type="hidden" name="id_patient" value="<?= $_SESSION['user']['id_patient']; ?>">
      <input type="hidden" name="action" value="ajouter">

      <div class="rdv-form-actions">
        <button type="submit" class="btn-primary">✅ Confirmer</button>
      </div>
    </form>
  </section>
</main>

</body>
</html>
