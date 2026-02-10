<center>
    <div class="medinfo-reset-wrapper">

        <section class="medinfo-reset-card">

            <h1 class="medinfo-card-title">Réinitialiser votre mot de passe</h1>

            <p class="medinfo-card-help-text">
                Choisissez un nouveau mot de passe sécurisé.
            </p>

            <?php
                if (!empty($_SESSION['reset_error'])): ?>
                    <p class="medinfo-error-text">
                        <?= htmlspecialchars($_SESSION['reset_error']); ?>
                    </p>
            <?php unset($_SESSION['reset_error']); endif; ?>

            <form action="index.php?page=controllerPatient" method="post" class="medinfo-reset-form">

                <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">

                <div class="medinfo-form-group">
                    <label for="mdp">Nouveau mot de passe</label>
                    <input
                        type="password"
                        id="mdp"
                        name="mdp"
                        placeholder="••••••••"
                        required
                    >
                </div>

                <div class="medinfo-form-group">
                    <label for="mdp2">Confirmer le mot de passe</label>
                    <input
                        type="password"
                        id="mdp2"
                        name="mdp2"
                        placeholder="••••••••"
                        required
                    >
                </div>

                <input type="hidden" name="action" value="reinitMdp">
                <button type="submit" class="medinfo-btn-primary">
                    Réinitialiser
                </button>

                <p class="medinfo-back-link">
                    <a href="index.php?page=connexion" class="medinfo-link">
                        Retour à la connexion
                    </a>
                </p>
            </form>

        </section>

    </div>
</center>