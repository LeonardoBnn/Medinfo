<div class="medinfo-login-wrapper">
        <!-- Colonne gauche : intro / rassurance -->
        <section class="medinfo-login-intro">
            <div class="medinfo-logo">
                <div class="medinfo-logo-icon">M</div>
                <div class="medinfo-logo-text">MedInfo</div>
            </div>

            <h1 class="medinfo-register-title">Accédez à vos rendez-vous en toute sérénité</h1>
            <p class="medinfo-register-subtitle">
                Retrouvez vos prochains rendez-vous, vos médecins favoris et vos informations de santé
                au même endroit, en toute sécurité.
            </p>

            <ul class="medinfo-benefits-list">
                <li>Suivi simplifié de vos rendez-vous</li>
                <li>Rappels automatiques par e-mail ou SMS</li>
                <li>Plateforme sécurisée et conforme aux bonnes pratiques</li>
            </ul>
        </section>

        <!-- Colonne droite : carte de connexion -->
        <section class="medinfo-login-card">
            <h2 class="medinfo-card-title">Connexion</h2>
            <p class="medinfo-card-help-text">
                Entrez vos identifiants pour accéder à votre espace sécurisé.
                <br>
                Pas encore de compte ?
                <a href="index.php?page=inscription" class="medinfo-link">Créer un compte</a>
            </p>

            <form method="POST" action="index.php?page=utilisateurController" class="medinfo-login-form">
                <!-- Email -->
                <div class="medinfo-form-group">
                    <label for="email">Adresse e-mail</label>
                    <input type="email" id="email" name="email" placeholder="nom.prenom@email.com" required>
                </div>

                <!-- Mot de passe avec icône oeil -->
                <div class="medinfo-form-group">
                    <label for="mdp">Mot de passe</label>
                    <div class="medinfo-password-wrapper">
                        <input type="password" id="mdp" name="mdp" placeholder="Votre mot de passe" required>

                    </div>
                    <!-- décommenter cette partie pour activer la fonctionnalité "Mot de passe oubliée"
                         Les controllers et modèles sont déjà actif.
                    <div class="medinfo-login-meta-row">
                        <a href="index.php?page=mdpOubliee" class="medinfo-link medinfo-link-small">
                            Mot de passe oublié ?
                        </a>
                    </div>
                     -->
                </div>

                <?php   //affichage du message d'erreur en cas d'identifiants invalides
                    if (!empty($_SESSION['login_error'])): ?>
                        <p class="medinfo-error-text">
                            <?= htmlspecialchars($_SESSION['login_error']); ?>
                        </p>
                    <?php
                        unset($_SESSION['login_error']); // on supprime après affichage
                    endif;
                ?>

                <!-- Bouton de connexion -->
                <input type="hidden" name="action" value="connexion">                 
                <button type="submit" class="medinfo-btn-primary">
                    Se connecter
                </button>

                <p class="medinfo-legal-note">
                    En vous connectant, vous acceptez les
                    <a href="index.php?page=CGU" class="medinfo-link">Conditions Générales d’Utilisation</a>
                    et notre
                    <a href="index.php?page=politiquesConfidentialite" class="medinfo-link">Politique de confidentialité</a>.
                </p>
            </form>
        </section>
    </div>