
<?php
   include("controller/utilisateur/controller.utilisateur.php");
?>


<div class="medinfo-register-wrapper">
        <!-- Colonne gauche : branding / message -->
        <section class="medinfo-register-intro">
            <div class="medinfo-logo">
                <span class="medinfo-logo-icon">M</span>
                <span class="medinfo-logo-text">MedInfo</span>
            </div>
            <h1 class="medinfo-register-title">
                Créez votre compte<br>pour prendre vos rendez-vous en ligne
            </h1>
            <p class="medinfo-register-subtitle">
                Une plateforme sécurisée pour gérer vos consultations, vos documents médicaux 
                et communiquer avec vos professionnels de santé.
            </p>

            <ul class="medinfo-benefits-list">
                <li>✔️ Prise de rendez-vous en quelques clics</li>
                <li>✔️ Rappels automatiques par e-mail</li>
                <li>✔️ Données de santé protégées</li>
            </ul>
        </section>

        <!-- Colonne droite : formulaire -->
        <section class="medinfo-register-card" aria-label="Formulaire d'inscription">
            <h2 class="medinfo-card-title">Inscription</h2>
            <p class="medinfo-card-help-text">
                Déjà inscrit ? <a href="index.php?page=connexion" class="medinfo-link">Connectez-vous</a>
            </p>

            <!-- Tu pourras adapter l'action vers ton contrôleur PHP -->
            <form method="POST" action="index.php?page=controllerPatient" class="medinfo-register-form">
                <div class="medinfo-form-row">
                    <div class="medinfo-form-group">
                        <label for="prenom">Prénom</label>
                        <input type="text" id="prenom" name="prenom" required placeholder="Votre prénom">
                    </div>
                    <div class="medinfo-form-group">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" required placeholder="Votre nom">
                    </div>
                </div>

                <div class="medinfo-form-group">
                    <label for="email">Adresse e-mail</label>
                    <input type="email" id="email" name="email" required placeholder="exemple@domaine.com">
                </div>

                <div class="medinfo-form-row">
                    <div class="medinfo-form-group">
                        <label for="date_naissance">Date de naissance</label>
                        <input type="date" id="date_naissance" name="date_naissance" required>
                    </div>
                    <div class="medinfo-form-group">
                        <label for="tel">Téléphone</label>
                        <input type="tel" id="tel" name="tel" placeholder="06 12 34 56 78">
                    </div>
                </div>

                <div class="medinfo-form-row">
                    <div class="medinfo-form-group">
                        <label for="mdp">Mot de passe</label>
                        <input type="password" id="mdp" name="mdp" required placeholder="••••••••">
                        <small class="medinfo-hint">
                            8 caractères minimum, avec une majuscule et un chiffre.
                        </small>
                    </div>
                    <div class="medinfo-form-group">
                        <label for="mdp_confirm">Confirmation</label>
                        <input type="password" id="mdp_confirm" name="mdp_confirm" required placeholder="••••••••">
                    </div>
                </div>

                <div class="medinfo-form-group">
                    <label for="adresse">Adresse postale</label>
                    <input type="text" id="adresse" name="adresse" required placeholder="00 rue MedInfo 75000 Paris">
                </div>

                <div class="medinfo-form-row">
                    <div class="medinfo-form-group">
                        <label for="num_secu">Numéro de sécurité sociale</label>
                        <input
                            type="text"
                            id="num_secu"
                            name="num_secu"
                            placeholder="2 99 99 99 999 999 99"
                            maxlength="15"
                            inputmode="numeric"
                        >
                    </div>

                    <div class="medinfo-form-group">
                        <label for="sexe">Sexe</label>
                        <select id="sexe" name="sexe">
                            <option value="" selected disabled>Choisir une option</option>
                            <option value="homme">Homme</option>
                            <option value="femme">Femme</option>
                            <option value="">Ne pas définir</option>
                        </select>
                    </div>
                </div>


                <div class="medinfo-checkbox-group">
                    <label class="medinfo-checkbox">
                        <input type="checkbox" name="cgu" required>
                        <span>
                            J’accepte les <a href="index.php?page=CGU" class="medinfo-link">conditions générales d’utilisation</a> 
                            et la <a href="index.php?page=politiquesConfidentialite" class="medinfo-link">politique de confidentialité</a>.
                        </span>
                    </label>
                </div>
                
                <input type="hidden" name="action" value="ajouter">
                <button type="submit" class="medinfo-btn-primary">
                    Créer mon compte
                </button>

                <p class="medinfo-legal-note">
                    Vos données sont utilisées uniquement dans le cadre de la gestion de vos rendez-vous 
                    et sont hébergées sur des serveurs sécurisés.
                </p>
            </form>
        </section>
    </div>