<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    
    <!-- Styles -->    
    <link rel="stylesheet" href="public/styles.connexion.css">
    <link rel="stylesheet" href="public/styles.inscription.css">
    <link rel="stylesheet" href="public/styles.mdpOublie.css">
    <link rel="stylesheet" href="public/styles.reinitialisationMdp.css">
    <link rel="stylesheet" href="public/styles.accueil.css">
    <link rel="stylesheet" href="public/styles.header.css">
    <link rel="stylesheet" href="public/styles.footer.css">
    <link rel="stylesheet" href="public/styles.agenda.css">
    <link rel="stylesheet" href="public/styles.ajoutConsultation.css">
    <link rel="stylesheet" href="public/styles.consultations.css">
    <link rel="stylesheet" href="public/styles.rdvMedecin.css">
    <link rel="stylesheet" href="public/styles.rdv.css">
    <link rel="stylesheet" href="public/styles.profil.css">
    <link rel="stylesheet" href="public/styles.RGPD.css">
    <link rel="stylesheet" href="public/styles.modifierProfil.css">

    <title>MedInfo</title>
</head>
<body>

<header class="medinfo-header">
    <div class="medinfo-header-inner">
        <!-- Logo MedInfo -->
        <div class="medinfo-logo">
            <img src="public/img/logo_medinfo.png" alt="Logo MedInfo" class="medinfo-logo-img">
            <span class="medinfo-logo-text">MedInfo</span>
        </div>

        <!-- Toggle mobile -->
        <input type="checkbox" id="medinfo-nav-toggle" class="medinfo-nav-toggle">
        <label for="medinfo-nav-toggle" class="medinfo-nav-burger" aria-label="Ouvrir la navigation">
            <span class="medinfo-nav-burger-lines"></span>
        </label>

        <!-- Nav + actions -->
        <div class="medinfo-header-right">
            <nav class="medinfo-nav" aria-label="Navigation principale">

                <a href="index.php?page=accueil" class="medinfo-nav-link">Accueil</a>

                <?php if(!empty($_SESSION['user'])): ?>
                    <?php if($_SESSION['user']['role'] === 'Patient'): ?>
                        <!-- Liens Patient -->
                        <a href="index.php?page=prendreRdv" class="medinfo-nav-link">Prendre rendez-vous</a>
                        <a href="index.php?page=rdvPatient" class="medinfo-nav-link">Mes rendez-vous</a>
                        <a href="index.php?page=mesConsultations" class="medinfo-nav-link">Mes consultations</a>
                        <a href="index.php?page=listeMedecins" class="medinfo-nav-link">Médecins</a>
                    
                    <?php elseif($_SESSION['user']['role'] === 'Medecin'): ?>
                        <!-- Liens Médecin (réduits) -->
                        <!--<a href="index.php?page=agenda" class="medinfo-nav-link">Mon agenda</a>-->
                        <a href="index.php?page=gestionRdv" class="medinfo-nav-link">Rendez-Vous</a>
                        <a href="index.php?page=consultationMedecin" class="medinfo-nav-link">Consultations</a>
                        <!-- Les autres outils (créneaux, patients, ajout consultation) sont accessibles depuis l'accueil médecin -->
                    <?php endif; ?>
                <?php endif; ?>
            </nav>

            <!-- Actions Connexion / Déconnexion -->
            <?php if(empty($_SESSION['user'])): ?>
                <div class="medinfo-header-actions">
                    <a href="index.php?page=connexion">
                        <button type="button" class="medinfo-btn-ghost">Connexion</button>
                    </a>
                    <a href="index.php?page=inscription">
                        <button type="button" class="medinfo-btn-primary-nav">S’inscrire</button>
                    </a>
                </div>
            <?php else: ?>
                <div class="medinfo-header-actions">

                    <a href="index.php?page=profil" class="profile-btn">
                        <span class="profile-avatar-initial">
                            <?= htmlspecialchars($_SESSION['user']['prenom'][0]) ?>
                        </span>
                    </a>

                    <a href="index.php?page=deconnexion">
                        <button type="button" class="medinfo-btn-primary-nav">Déconnexion</button>
                    </a>

                </div>
            <?php endif; ?>


        </div>
    </div>
</header>

