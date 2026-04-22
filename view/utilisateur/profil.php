<?php
$user = $_SESSION['user'];
?>

<div class="profile-page">

    <section class="profile-card">

        <!-- Avatar -->
        <div class="profile-avatar">
            <div class="avatar-circle">
                <?= htmlspecialchars($user['prenom'][0]) ?>
            </div>
        </div>

        <!-- Infos principales -->
        <div class="profile-info">

            <h1 class="profile-name">
                <?= htmlspecialchars($user['prenom'] . " " . $user['nom']) ?>
            </h1>
        
            <p class="profile-role">
                <?= htmlspecialchars($user['role']) ?>
            </p>

            <div class="profile-details">

                <div class="detail">
                    <label>Email</label>
                    <div><?= htmlspecialchars($user['email']) ?></div>
                </div>

                <div class="detail">
                    <label>Téléphone</label>
                    <div><?= htmlspecialchars($user['telephone']) ?></div>
                </div>

                <?php if ($user['role'] === 'Patient'): ?>
                    <div class="detail">
                        <label>Adresse</label>
                        <div><?= htmlspecialchars($user['adresse']) ?></div>
                    </div>

                    <!--
                    <div class="detail">
                        <label>Numéro de sécurité sociale</label>
                        <div><?= htmlspecialchars($user['num_secu']) ?></div>
                    </div>
                    -->

                    <div class="detail">
                        <label>Sexe</label>
                        <div><?= htmlspecialchars($user['sexe']) ?></div>
                    </div>
                <?php endif; ?>

                <?php if ($user['role'] === 'Medecin'): ?>
                    <div class="detail">
                        <label>Spécialité</label>
                        <div><?= htmlspecialchars($user['libelle_specialite'] ?? '—') ?></div>
                    </div>

                    <div class="detail">
                        <label>Description</label>
                        <div><?= nl2br(htmlspecialchars($user['description'] ?? 'Aucune description')) ?></div>
                    </div>
                <?php endif; ?>

            </div>

            <a href="index.php?page=modifierProfil" class="btn-edit-profile">
                Modifier mon profil
            </a>

        </div>
    </section>

