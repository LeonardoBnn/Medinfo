<footer class="medinfo-footer">
    <div class="medinfo-footer-inner">
        <!-- Bloc logo + phrase rassurante -->
        <div class="medinfo-footer-brand">
            <a href="index.php" class="medinfo-logo">
                <span class="medinfo-logo-icon">M</span>
                <span class="medinfo-logo-text">MedInfo</span>
            </a>
            <p class="medinfo-footer-tagline">
                Prenez rendez-vous simplement dans votre centre médical pluridisciplinaire,
                en toute sécurité et en quelques clics.
            </p>
        </div>

        <!-- Colonnes de navigation -->
        <div class="medinfo-footer-columns">
            <div class="medinfo-footer-column">
                <h3 class="medinfo-footer-title">Navigation</h3>
                <ul class="medinfo-footer-list">
                    <li><a href="index.php" class="medinfo-footer-link">Accueil</a></li>
                    <li><a href="index.php?page=connexion" class="medinfo-footer-link">Se connecter</a></li>
                    <li><a href="index.php?page=inscription" class="medinfo-footer-link">Créer un compte</a></li>
                </ul>
            </div>

            <div class="medinfo-footer-column">
                <?php if(!empty($_SESSION['user'])){
                        if($_SESSION['user']['role'] == 'Patient'){?>
                            <h3 class="medinfo-footer-title">Patient</h3>
                            <ul class="medinfo-footer-list">
                                <li><a href="index.php?page=prendreRdv" class="medinfo-footer-link">Prendre rendez-vous</a></li>
                                <li><a href="index.php?page=monEspace" class="medinfo-footer-link">Mon espace santé</a></li>
                            </ul>
                    <?php }else{?>
                            <h3 class="medinfo-footer-title">Médecin</h3>
                            <ul class="medinfo-footer-list">
                                <li><a href="index.php?page=agenda" class="medinfo-footer-link">Mon agenda</a></li>
                                <li><a href="index.php?page=demandesRdv" class="medinfo-footer-link">Gestion Rendez-Vous</a></li>
                                <li><a href="index.php?page=consultationMedecin" class="medinfo-footer-link">Historique Consultations</a></li>
                                <li><a href="index.php?page=ajouterConsultation" class="medinfo-footer-link">Demarrer une Consultations</a></li>
                            </ul>
                    <?php }
                }?>
            </div>
        </div>
    </div>

    <!-- Ligne basse -->
    <div class="medinfo-footer-bottom">
        <div class="medinfo-footer-bottom-inner">
            <div class="medinfo-footer-bottom-left">
                <span>© <?php echo date('Y'); ?> MedInfo.</span>
                <span>Tous droits réservés.</span>
            </div>

            <div class="medinfo-footer-bottom-right">
                <a href="index.php?page=CGU" class="medinfo-footer-bottom-link">CGU</a>
                <a href="index.php?page=politiquesConfidentialite" class="medinfo-footer-bottom-link">
                    Politique de confidentialité
                </a>
                <a href="index.php?page=mentionsLegales" class="medinfo-footer-bottom-link">Mentions légales</a>

                <!-- 
                Social (optionnel, remplace les # par tes liens) 
                <div class="medinfo-footer-socials">
                    <a href="#" class="medinfo-footer-social-link" aria-label="LinkedIn MedInfo">In</a>
                    <a href="#" class="medinfo-footer-social-link" aria-label="Facebook MedInfo">f</a>
                </div>
                -->

                <!-- Bloc Le Backyard -->
                <div class="backyard-footer">
                    <img src="public/img/logoLeBackyard.jpg" alt="Logo Le Backyard" class="backyard-footer-logo">
                    <span class="backyard-footer-credit">Développé par Le Backyard</span>
                </div>
                
            </div>
        </div>
    </div>
</footer>

</body>
</html>


