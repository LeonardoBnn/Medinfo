<?php
//var_dump($_SESSION['user']);
//die();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Consultation - MedInfo</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@500;600;700&family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="styles.consultation.css">
    </head>
<body>

    <div class="medinfo-consultation-wrapper">
        
        <div class="medinfo-consultation-card">
            
            <div class="medinfo-card-header">
                <h1 class="medinfo-card-title">Nouvelle Consultation</h1>
                <p class="medinfo-card-subtitle">Remplissez les informations médicales pour ce patient.</p>
            </div>

            <form action="index.php?page=consultationController" method="POST" class="medinfo-form-grid">
                
                <!--récupération de id medecin et patient -->
                <input type="hidden" name="id_patient" value="<?php echo $_GET['id_patient']; ?>">
                <input type="hidden" name="id_medecin" value="<?php echo $_SESSION['user']['id_medecin']; ?>">

                <div class="medinfo-form-row">
                    <div class="medinfo-form-group">
                        <label for="tension">Tension artérielle <span style="color:var(--medinfo-danger)">*</span></label>
                        <input type="text" id="tension" name="tension" placeholder="ex: 12/8" required>
                    </div>

                    <div class="medinfo-form-group">
                        <label for="poids">Poids <span style="color:var(--medinfo-danger)">*</span></label>
                        <input type="text" id="poids" name="poids" placeholder="ex: 75 kg" required>
                    </div>
                </div>

                <div class="medinfo-form-group">
                    <label for="compte_rendu">Compte-rendu de consultation <span style="color:var(--medinfo-danger)">*</span></label>
                    <textarea id="compte_rendu" name="compte_rendu" rows="6" placeholder="Détails du diagnostic et de l'échange..." required></textarea>
                </div>

                <div class="medinfo-form-group">
                    <label for="observations">Observations complémentaires</label>
                    <textarea id="observations" name="observations" rows="3" placeholder="Notes privées, antécédents à vérifier..."></textarea>
                </div>
                
                <input type="hidden" name="action" value="ajouter">
                <button type="submit" class="medinfo-btn-submit">
                    Enregistrer la consultation
                </button>

            </form>
        </div>
    </div>

</body>
</html>