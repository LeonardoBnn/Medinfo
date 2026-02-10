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
        <p>Votre plateforme officielle du Centre Médical Ramsay Saint‑Lazare pour prendre rendez-vous en ligne,
           simple, rapide et sécurisée.</p>
        <button class="btn-primary">Prendre rendez-vous</button>
    </section>

    <section class="specialites">
        <h3>Nos spécialités médicales</h3>
        <ul class="specialite-list">
            <li>🦷 Dentisterie</li>
            <li>❤️ Cardiologie</li>
            <li>🌿 Dermatologie</li>
            <li>👶 Pédiatrie</li>
            <li>🧠 Neurologie</li>
            <li>👩‍⚕️ Médecine générale</li>
            <li>👁️ Ophtalmologie</li>
            <li>👂 ORL</li>
            <li>🦴 Orthopédie</li>
            <li>🧬 Endocrinologie</li>
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
        <p>Centre Médical Ramsay Saint‑Lazare<br>
        13 Rue de la Pépinière, 75008 Paris</p>
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.462314028329!2d2.324236315674!3d48.87535677928995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66e3a3b5f4b6b%3A0xabcdef123456789!2sCentre%20M%C3%A9dical%20Ramsay%20Sant%C3%A9%20Saint-Lazare!5e0!3m2!1sfr!2sfr!4v1733250000"
            width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy">
        </iframe>
    </section>




    <?php

} elseif ($_SESSION['user']['role'] === 'Patient') {
    // ===========================
    // Accueil patient
    // ===========================
    ?>
    <section class="main-section">
        <h2>Bonjour <?= htmlspecialchars($_SESSION['user']['prenom']); ?> 👋</h2>
        <p>Bienvenue dans votre espace santé du Centre Médical Ramsay Saint‑Lazare.</p>
    </section>

    <section class="dashboard patient-dashboard">
        <h3>Mes actions rapides</h3>
        <div class="actions-grid">
            <a href="index.php?page=prendreRdv" class="action-card">
                <span class="icon">📅</span>
                <span class="text">Prendre rendez-vous</span>
            </a>
            <a href="index.php?page=rdvPatient" class="action-card">
                <span class="icon">📋</span>
                <span class="text">Mes rendez-vous</span>
            </a>
            <a href="index.php?page=monEspace" class="action-card">
                <span class="icon">🩺</span>
                <span class="text">Mon espace santé</span>
            </a>
            <a href="index.php?page=mesConsultations" class="action-card">
                <span class="icon">📖</span>
                <span class="text">Mes consultations</span>
            </a>
            <a href="index.php?page=mesDocuments" class="action-card">
                <span class="icon">📂</span>
                <span class="text">Mes documents médicaux</span>
            </a>
        </div>
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
            <a href="index.php?page=creneauxMedecin" class="action-card">
                <span class="icon">🗓️</span>
                <span class="text">Mes créneaux</span>
            </a>
            <a href="index.php?page=consultationMedecin" class="action-card">
                <span class="icon">🩺</span>
                <span class="text">Historique des consultations</span>
            </a>
            <a href="index.php?page=ajouterConsultation" class="action-card">
                <span class="icon">➕</span>
                <span class="text">Démarrer une consultation</span>
            </a>
            <a href="index.php?page=mesPatients" class="action-card">
                <span class="icon">👥</span>
                <span class="text">Mes patients</span>
            </a>
        </div>
    </section>
    <?php

}
?>
