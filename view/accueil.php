<?php
//var_dump($_SESSION['user']);
//die();
// Vérifie si l'utilisateur est connecté
if (empty($_SESSION['user'])) {
    // ===========================
    // Accueil public (non connecté)
    // ===========================
    ?>
    <section class="main-section">
        <h2>Bienvenue sur MedInfo</h2>
        <p>Votre plateforme officielle du Centre Médical Ramsay Miromesnil pour prendre rendez-vous en ligne,
           simple, rapide et sécurisée.</p>
        <button class="btn-primary"><a style="text-decoration:none;color:white"href="index.php?page=connexion">Prendre rendez-vous</a></button>
    </section>

    <section class="specialites">
        <h3>Nos spécialités médicales</h3>
        <ul class="specialite-list">
            <li><a href="index.php?page=listeMedecins&specialite=1">❤️ Cardiologie</a></li>
            <li><a href="index.php?page=listeMedecins&specialite=2">🌿 Dermatologie</a></li>
            <li><a href="index.php?page=listeMedecins&specialite=3">🤰 Gynécologie</a></li>
            <li><a href="index.php?page=listeMedecins&specialite=4">👶 Pédiatrie</a></li>
            <li><a href="index.php?page=listeMedecins&specialite=5">🧠 Neurologie</a></li>
            <li><a href="index.php?page=listeMedecins&specialite=6">🧬 Endocrinologie</a></li>
            <li><a href="index.php?page=listeMedecins&specialite=13">👂 ORL</a></li>
            <li><a href="index.php?page=listeMedecins&specialite=14">👁️ Ophtalmologie</a></li>
            <li><a href="index.php?page=listeMedecins&specialite=16">👩‍⚕️ Médecine générale</a></li>
        </ul>
    </section>

    <section class="how-it-works">
        <h3>Comment ça marche ?</h3>
        <div class="steps">
            <div class="step">1️⃣ Créez votre compte</div>
            <div class="step">2️⃣ Choisissez votre médecin</div>
            <div class="step">3️⃣ Réservez votre rendez-vous</div>
        </div>
    </section>

    <section class="access">
        <h3>Nous trouver</h3>
        <p>Centre Médical Ramsay Miromesnil<br>
        6 Av. César Caire, 75008 Paris</p>
<iframe id="map-canvas" class="map_part" width="600"  height="450"  frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%&amp;height=100%&amp;hl=en&amp;q=6 av césar caire 75008 paris&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed">Powered by <a href="https://embedgooglemaps.com">google maps embed</a> and <a href="https://allabeviljas.se/">sms lån som beviljar alla</a></iframe>
    </section>

    <?php

} elseif ($_SESSION['user']['role'] === 'Patient') {
    // ===========================
    // Accueil patient
    // ===========================
    ?>
    <section class="main-section">
        <h2>Bonjour <?= htmlspecialchars($_SESSION['user']['prenom']); ?> 👋</h2>
        <p>Bienvenue dans votre espace santé du Centre Médical Ramsay Miromesnil.</p>
    </section>

    <section class="specialites">
        <h3>Nos spécialités médicales</h3>
        <ul class="specialite-list">
            <li><a href="index.php?page=listeMedecins&specialite=1">❤️ Cardiologie</a></li>
            <li><a href="index.php?page=listeMedecins&specialite=2">🌿 Dermatologie</a></li>
            <li><a href="index.php?page=listeMedecins&specialite=3">🤰 Gynécologie</a></li>
            <li><a href="index.php?page=listeMedecins&specialite=4">👶 Pédiatrie</a></li>
            <li><a href="index.php?page=listeMedecins&specialite=5">🧠 Neurologie</a></li>
            <li><a href="index.php?page=listeMedecins&specialite=6">🧬 Endocrinologie</a></li>
            <li><a href="index.php?page=listeMedecins&specialite=13">👂 ORL</a></li>
            <li><a href="index.php?page=listeMedecins&specialite=14">👁️ Ophtalmologie</a></li>
            <li><a href="index.php?page=listeMedecins&specialite=16">👩‍⚕️ Médecine générale</a></li>
        </ul>
    </section>

    <section class="access">
        <h3>Nous trouver</h3>
        <p>Centre Médical Ramsay Miromesnil<br>
        6 Av. César Caire, 75008 Paris</p>

        <iframe id="map-canvas" class="map_part" width="600" height="450" frameborder="0" scrolling="no"
            src="https://maps.google.com/maps?width=100%&amp;height=100%&amp;hl=en&amp;q=6 av césar caire 75008 paris&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed">
        </iframe>
    </section>
    
    <?php


} elseif ($_SESSION['user']['role'] === 'Medecin') {
    // ===========================
    // Accueil médecin
    // ===========================
    ?>
    <section class="main-section">
        <h2>Bonjour Dr. <?= htmlspecialchars($_SESSION['user']['nom']); ?> 👋</h2>
        <p>Bienvenue dans votre espace professionnel du Centre Médical Ramsay Saint‑Lazare.</p>
    </section>

    <section class="dashboard medecin-dashboard">
        <h3>Mes outils</h3>
        <div class="actions-grid">
            <a href="index.php?page=agenda" class="action-card">
                <span class="icon">📅</span>
                <span class="text">Mon agenda</span>
            </a>
            <a href="index.php?page=gestionRdv" class="action-card">
                <span class="icon">📋</span>
                <span class="text">Gestion des rendez-vous</span>
            </a>
            <!--
            <a href="index.php?page=creneauxMedecin" class="action-card">
                <span class="icon">🗓️</span>
                <span class="text">Mes créneaux</span>
            </a>
            -->
            <a href="index.php?page=consultationMedecin" class="action-card">
                <span class="icon">🩺</span>
                <span class="text">Historique des consultations</span>
            </a>
            <a href="index.php?page=ajouterConsultation" class="action-card">
                <span class="icon">➕</span>
                <span class="text">Démarrer une consultation</span>
            </a>
            <!--
            <a href="index.php?page=mesPatients" class="action-card">
                <span class="icon">👥</span>
                <span class="text">Mes patients</span>
            </a>
        </div>
            -->
    </section>
    <?php

}
?>
