<?php

Class Rendez_vous{

    private $bdd;
    
    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    public function ajouterRdv($motif, $origine, $id_patient, $id_creneau){

        $req = $this->bdd->prepare("INSERT INTO rendez_vous(motif, origine, fk_id_patient, fk_id_creneau) VALUES (:motif, :origine, :id_patient, :id_creneau)");

        $req->bindparam(":motif", $motif);
        $req->bindparam(":origine", $origine);
        $req->bindparam(":id_patient", $id_patient);
        $req->bindparam(":id_creneau", $id_creneau);
        
        return $req->execute();
    }

    //récupérer tous les rdv selon le médecin connécté 
    public function getAllRdvPatient($id_utilisateur)
{
    $req = $this->bdd->prepare("
        SELECT 
            rdv.id_rdv,
            rdv.date_creation,
            rdv.motif,
            rdv.statut AS rdv_statut,
            c.date_heure_debut,
            c.date_heure_fin,
            -- Alias pour le médecin
            mu.nom AS medecin_nom,
            mu.prenom AS medecin_prenom,
            s.libelle AS salle_libelle,
            s.etage AS salle_etage
        FROM 
            rendez_vous rdv
        INNER JOIN 
            creneau c ON rdv.fk_id_creneau = c.id_creneau
        INNER JOIN 
            patient p ON rdv.fk_id_patient = p.id_patient
        -- Jointures supplémentaires pour récupérer le nom du Médecin (qui n'est pas dans le créneau directement)
        INNER JOIN 
            medecin m ON c.fk_id_medecin = m.id_medecin
        INNER JOIN
            salle s ON c.fk_id_salle = s.id_salle
        INNER JOIN 
            utilisateur mu ON m.fk_id_utilisateur = mu.id_utilisateur
        WHERE 
            p.fk_id_utilisateur = :id_utilisateur -- Filtre sur l'ID utilisateur du patient
        ORDER BY 
            c.date_heure_debut DESC -- Tri par date la plus récente
    ");

    $req->bindParam(':id_utilisateur', $id_utilisateur);
    $req->execute();

    return $req->fetchAll();
}

    public function getAllRdvMedecin($id_utilisateur){
           
        $req = $this->bdd->prepare("
            SELECT 
            rdv.id_rdv,
            rdv.date_creation,
            rdv.motif,
            rdv.statut AS rdv_statut,
            rdv.fk_id_patient AS id_patient,
            TIME_FORMAT(c.date_heure_debut, '%H:%i') AS heure_debut_formatee,
            c.date_heure_fin,
            s.libelle AS salle_libelle,
            s.etage AS salle_etage,
            -- Alias pour le patient (ce que le médecin veut voir)
            pu.nom AS patient_nom,
            pu.prenom AS patient_prenom,
            pu.email as patient_email
            
        FROM 
            rendez_vous rdv
        INNER JOIN 
            creneau c ON rdv.fk_id_creneau = c.id_creneau
        INNER JOIN 
            patient p ON rdv.fk_id_patient = p.id_patient
        INNER JOIN 
            utilisateur pu ON p.fk_id_utilisateur = pu.id_utilisateur -- Récupère les infos du patient
        INNER JOIN 
            medecin m ON c.fk_id_medecin = m.id_medecin
        INNER JOIN
            salle s ON c.fk_id_salle = s.id_salle
        -- Jointure essentielle pour filtrer sur l'ID utilisateur du médecin
        INNER JOIN 
            utilisateur mu ON m.fk_id_utilisateur = mu.id_utilisateur 
            
        WHERE 
            mu.id_utilisateur = :id_utilisateur -- Filtre sur l'ID utilisateur du médecin
            
        ORDER BY 
            c.date_heure_debut DESC
        ");
        
        $req->bindParam(':id_utilisateur', $id_utilisateur);
        $req->execute();

        return $req->fetchAll();
    }

    public function allCreneaux() {
    $req = $this->bdd->prepare("
        SELECT 
            c.id_creneau,
            c.date_heure_debut,
            c.date_heure_fin,
            mu.nom AS medecin_nom,
            mu.prenom AS medecin_prenom,
            s.libelle AS salle_libelle,
            s.etage AS salle_etage
        FROM creneau c
        INNER JOIN medecin m ON c.fk_id_medecin = m.id_medecin
        INNER JOIN utilisateur mu ON m.fk_id_utilisateur = mu.id_utilisateur
        INNER JOIN salle s ON c.fk_id_salle = s.id_salle
        ORDER BY c.date_heure_debut ASC
    ");
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}



    public function supprimerRdv($id_rdv){

        $req = $this->bdd->prepare("DELETE rendez_vous WHERE id_rdv = :id_rdv");

        $req->bindparam(':id_rdv', $id_rdv);

        return $req->execute();
    }

    // Récupérer les créneaux libres d'un médecin, filtrables par date
    public function getCreneauxDispoByMedecin($id_medecin, $date = null) {
        $sql = "SELECT c.id_creneau, c.date_heure_debut, c.date_heure_fin, s.libelle AS salle_libelle
                FROM creneau c
                INNER JOIN salle s ON c.fk_id_salle = s.id_salle
                WHERE c.fk_id_medecin = :id_medecin AND c.statut = 'libre'";

        // Si une date est choisie dans le filtre, on l'ajoute à la requête
        if ($date != null) {
            $sql .= " AND DATE(c.date_heure_debut) = :date";
        }
        $sql .= " ORDER BY c.date_heure_debut ASC";

        $req = $this->bdd->prepare($sql);
        $req->bindParam(':id_medecin', $id_medecin);
        if ($date != null) {
            $req->bindParam(':date', $date);
        }
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    //Changer le statut du creneaux à la prise du rdv
    public function updateStatutCreneau($statut, $id_creneau){
        $req = $this->bdd->prepare("UPDATE creneau SET statut = :creneauStatut where id_creneau = :id_creneau");
        $req->bindParam(':creneauStatut', $statut);
        $req->bindParam(':id_creneau', $id_creneau);

        return $req->execute();
    }

    // Récupérer les informations d'un créneau spécifique pour le récapitulatif
    public function getCreneauInfos($id_creneau) {
        $req = $this->bdd->prepare("
            SELECT c.date_heure_debut, mu.nom AS medecin_nom, mu.prenom AS medecin_prenom
            FROM creneau c
            INNER JOIN medecin m ON c.fk_id_medecin = m.id_medecin
            INNER JOIN utilisateur mu ON m.fk_id_utilisateur = mu.id_utilisateur
            WHERE c.id_creneau = :id_creneau
        ");
        $req->bindParam(':id_creneau', $id_creneau);
        $req->execute();
        return $req->fetch(PDO::FETCH_ASSOC);
    }

    // Fonctions pour les actions du tableau de gestion des rdv
    public function updateRdvStatus($rdv_id, $rdvStatut){

        $req = $this->bdd->prepare("UPDATE rendez_vous SET statut = :rdvStatut where id_rdv = :rdv_id");
        $req->bindParam(':rdvStatut', $rdvStatut);
        $req->bindParam(':rdv_id', $rdv_id);

        return $req->execute();
    }

    // Libérer le créneau associé à un rendez-vous annulé
    public function libererCreneauByRdv($id_rdv) {
        $req = $this->bdd->prepare("
            UPDATE creneau 
            SET statut = 'libre', disponibilite = 1 
            WHERE id_creneau = (
                SELECT fk_id_creneau 
                FROM rendez_vous 
                WHERE id_rdv = :id_rdv
            )
        ");
        $req->bindParam(':id_rdv', $id_rdv);
        return $req->execute();
    }
}


?>