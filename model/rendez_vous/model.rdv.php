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
            pu.prenom AS patient_prenom
            
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

        $req = $this->bdd->prepare("DELETE * FROM rendez_vous WHERE id_rdv = :id_rdv");

        $req->bindparam(':id_rdv', $id_rdv);

        return $req->execute();
    }
}


?>