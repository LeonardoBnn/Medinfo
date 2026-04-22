<?php
$user = $_SESSION['user'];
?>

<div class="edit-profile-page">

    <h1>Modifier mon profil</h1>

<?php 
$role = strtolower($user['role']); 
if ($role === 'medecin'): ?>
    <form action="index.php?page=controllerMedecin" method="POST">
<?php else: ?>
    <form action="index.php?page=controllerPatient" method="POST">
<?php endif; ?>

        <input type="hidden" name="action" value="modifier">

        <!-- NOM -->
        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required>
        </div>

        <!-- PRENOM -->
        <div class="form-group">
            <label>Prénom</label>
            <input type="text" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?>" required>
        </div>

        <!-- EMAIL -->
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <!-- TELEPHONE -->
        <div class="form-group">
            <label>Téléphone</label>
            <input type="text" name="tel" value="<?= htmlspecialchars($user['telephone']) ?>" required>
        </div>

        <!-- PATIENT -->
        <?php if ($user['role'] === 'Patient'): ?>

            <div class="form-group">
                <label>Adresse</label>
                <input type="text" name="adresse" value="<?= htmlspecialchars($user['adresse']) ?>">
            </div>

            <div class="form-group">
                <label>Sexe</label>
                <select name="sexe">
                    <option value="Homme" <?= $user['sexe'] === 'Homme' ? 'selected' : '' ?>>Homme</option>
                    <option value="Femme" <?= $user['sexe'] === 'Femme' ? 'selected' : '' ?>>Femme</option>
                    <option value="Autre" <?= $user['sexe'] === 'Autre' ? 'selected' : '' ?>>Autre</option>
                </select>
            </div>

        <?php endif; ?>

        <!-- MEDECIN -->
        <?php if ($role === 'medecin'): ?>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="5"><?= htmlspecialchars($user['description'] ?? '') ?></textarea>
            </div>

        <?php endif; ?>

        <button type="submit" class="btn-save">Enregistrer</button>

    </form>

</div>
