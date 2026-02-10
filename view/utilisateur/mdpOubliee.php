<center>
    <div class="medinfo-forgot-wrapper">

        <section class="medinfo-forgot-card">

            <h1 class="medinfo-card-title">Mot de passe oublié</h1>

            <p class="medinfo-card-help-text">
                Entrez votre adresse e-mail pour recevoir un lien de réinitialisation.
            </p>

            <!-- Message d’erreur (optionnel) -->
            <?php
                
                if (!empty($_SESSION['forgot_error'])): ?>
                    <p class="medinfo-error-text">
                        <?= htmlspecialchars($_SESSION['forgot_error']); ?>
                    </p>
                <?php unset($_SESSION['forgot_error']); endif;
            ?>

            <!-- Message de succès -->
            <?php if (!empty($_SESSION['forgot_success'])): ?>
                <p class="medinfo-success-text">
                    <?= htmlspecialchars($_SESSION['forgot_success']); ?>
                </p>
            <?php unset($_SESSION['forgot_success']); endif; ?>

            <form action="index.php?page=controllerPatient" method="post" class="medinfo-forgot-form">

                <div class="medinfo-form-group">
                    <label for="email">Adresse e-mail</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="nom.prenom@email.com"
                        required
                    >
                </div>

                <input type="hidden" name="action" value="mdpOubliee">
                <button type="submit" class="medinfo-btn-primary">
                    Envoyer le lien
                </button>

                <p class="medinfo-back-link">
                    <a href="index.php?page=connexion" class="medinfo-link">Retour à la connexion</a>
                </p>

            </form>

        </section>

    </div>
</center>