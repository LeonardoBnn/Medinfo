<?php
/*Sécurité : si pas connecté → redirection
if (empty($_SESSION['user'])) {
    header("Location: index.php?page=connexion");
    exit;
} */

$user = $_SESSION['user'];
?>

<!-- <link rel="stylesheet" href="public/styles.profil.css"> -->

<div class="profile-page">

    <section class="profile-card">

        <!-- Avatar -->
        <div class="profile-avatar">
            <div class="avatar-circle">
                <?= htmlspecialchars($user['prenom'][0]) ?>
            </div>

        <!--
            <span class="status-badge">
                <?= htmlspecialchars($user['role']) ?>
            </span> -->
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
                <?php endif; ?>

                <?php if ($user['role'] === 'Medecin'): ?>
                    <div class="detail">
                        <label>Spécialité</label>
                        <div><?= htmlspecialchars($user['libelle_specialite'] ?? '—') ?></div>
                    </div>
                <?php endif; ?>

            </div>

        </div>
    </section>

    <!--
    <section class="profile-extra">
        <h2>Mes actions</h2>

        <div class="extra-grid">

            <?php if ($user['role'] === 'Patient'): ?>

                <div class="card">
                    <h3>Mes rendez-vous</h3>
                    <p><a href="index.php?page=rdvPatient">Voir mes rendez-vous</a></p>
                </div>

                <div class="card">
                    <h3>Mes documents</h3>
                    <p><a href="index.php?page=mesDocuments">Voir mes documents</a></p>
                </div>

            <?php elseif ($user['role'] === 'Medecin'): ?>

                <div class="card">
                    <h3>Mon agenda</h3>
                    <p><a href="index.php?page=agenda">Accéder</a></p>
                </div>

                <div class="card">
                    <h3>Mes consultations</h3>
                    <p><a href="index.php?page=consultationMedecin">Voir</a></p>
                </div>

            <?php endif; ?>

        </div>
    </section>
            -->

</div>
