<main class="profile-page">
    <section class="profile-card">
        <div class="profile-avatar">
            <?php
            // Initiale pour l'avatar
            $initial = strtoupper(substr($user['prenom'] ?? 'U', 0, 1));
            ?>
            <div class="avatar-circle"><?= htmlspecialchars($initial, ENT_QUOTES, 'UTF-8') ?></div>

            <!-- Pastille de rôle -->
            <?php
            $role = $user['role'] ?? '';
            $roleLabel = htmlspecialchars($role, ENT_QUOTES, 'UTF-8');
            $roleClass = (mb_strtolower($role, 'UTF-8') === 'patient') ? 'badge-patient' : 'badge-medecin';
            ?>
            <span class="status-badge <?= $roleClass ?>"><?= $roleLabel ?></span>
        </div>

        <div class="profile-info">
            <?php
            // Nettoyer nom/prénom au cas où "Dr" ou "Docteur" seraient présents dans les données
            $nomRaw = $user['nom'] ?? '';
            $prenomRaw = $user['prenom'] ?? '';

            $nomClean = preg_replace('/\b(dr\.?|docteur)\b/i', '', $nomRaw);
            $prenomClean = preg_replace('/\b(dr\.?|docteur)\b/i', '', $prenomRaw);

            $displayName = trim($nomClean . ' ' . $prenomClean);
            if ($displayName === '') {
                $displayName = htmlspecialchars($user['email'] ?? 'Utilisateur', ENT_QUOTES, 'UTF-8');
            } else {
                $displayName = htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8');
            }
            ?>
            <h1 class="profile-name"><?= $displayName ?></h1>
            <p class="profile-role"><?= $roleLabel ?></p>

            <div class="profile-details">
                <div class="detail">
                    <label>Email</label>
                    <div><?= htmlspecialchars($user['email'] ?? '—', ENT_QUOTES, 'UTF-8') ?></div>
                </div>
                <div class="detail">
                    <label>Téléphone</label>
                    <div><?= htmlspecialchars($user['telephone'] ?? '—', ENT_QUOTES, 'UTF-8') ?></div>
                </div>
                <div class="detail">
                    <label>Adresse</label>
                    <div><?= nl2br(htmlspecialchars($user['adresse'] ?? '—', ENT_QUOTES, 'UTF-8')) ?></div>
                </div>
            </div>

            <div class="profile-actions">
                <a class="btn-primary" href="index.php?page=modifierProfil">Modifier le profil</a>
                <?php if (mb_strtolower($role, 'UTF-8') === 'patient'): ?>
                    <a class="btn-secondary" href="index.php?page=prendreRdv">Prendre rendez-vous</a>
                <?php else: ?>
                    <a class="btn-secondary" href="index.php?page=agenda">Voir mon agenda</a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="profile-extra">
        <h2>Informations complémentaires</h2>
        <div class="extra-grid">
            <div class="card">
                <h3>Mes rendez-vous</h3>
                <p><a href="index.php?page=rdvPatient">Consulter mes rendez-vous</a></p>
            </div>
            <div class="card">
                <h3>Documents</h3>
                <p><a href="index.php?page=mesDocuments">Accéder à mes documents médicaux</a></p>
            </div>
            <div class="card">
                <h3>Paramètres</h3>
                <p><a href="index.php?page=monEspace">Gérer mon compte</a></p>
            </div>
        </div>
    </section>
</main>
