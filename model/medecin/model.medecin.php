<?php
require_once ROOT . 'model/utilisateur/model.utilisateur.php';

class Medecin extends Utilisateur {

          private $bdd;

    function __construct($bdd)
    {
        parent::__construct($bdd); // on appelle le constructeur de Utilisateur
        $this->bdd=$bdd;
    }

    // -------------------------
    // CRUD Médecin
    // -------------------------

    // Créer un médecin (lié à un utilisateur existant)
    public function createMedecin($rpps, $est_conventionne, $formations, $langues, $experiences, $description, $fk_id_utilisateur, $fk_id_specialite){
        $req = $this->bdd->prepare("INSERT INTO medecin(rpps, est_conventionne, formations, langues_parlees, experiences, description, fk_id_utilisateur, fk_id_specialite) 
                                    VALUES (:rpps, :est_conventionne, :formations, :langues, :experiences, :description, :fk_id_utilisateur, :fk_id_specialite)");
        $req->bindParam(':rpps', $rpps);
        $req->bindParam(':est_conventionne', $est_conventionne);
        $req->bindParam(':formations', $formations);
        $req->bindParam(':langues', $langues);
        $req->bindParam(':experiences', $experiences);
        $req->bindParam(':description', $description);
        $req->bindParam(':fk_id_utilisateur', $fk_id_utilisateur);
        $req->bindParam(':fk_id_specialite', $fk_id_specialite);

        return $req->execute();
    }

    // Lire tous les médecins
    public function readMedecin(){
        $req = $this->bdd->prepare("SELECT m.*, u.nom, u.prenom, s.libelle AS specialite
                                    FROM medecin m
                                    JOIN utilisateur u ON m.fk_id_utilisateur = u.id_utilisateur
                                    JOIN specialite s ON m.fk_id_specialite = s.id_specialite");
        $req->execute();
        return $req->fetchAll();
    }

    // Mettre à jour un médecin
    public function updateMedecin($id_medecin, $rpps, $est_conventionne, $formations, $langues, $experiences, $description, $fk_id_specialite){
        $req = $this->bdd->prepare("UPDATE medecin 
                                    SET rpps = :rpps, est_conventionne = :est_conventionne, formations = :formations, langues_parlees = :langues, experiences = :experiences, description = :description, fk_id_specialite = :fk_id_specialite
                                    WHERE id_medecin = :id_medecin");
        $req->bindParam(':rpps', $rpps);
        $req->bindParam(':est_conventionne', $est_conventionne);
        $req->bindParam(':formations', $formations);
        $req->bindParam(':langues', $langues);
        $req->bindParam(':experiences', $experiences);
        $req->bindParam(':description', $description);
        $req->bindParam(':fk_id_specialite', $fk_id_specialite);
        $req->bindParam(':id_medecin', $id_medecin);

        return $req->execute();
    }

    // Supprimer un médecin
    public function deleteMedecin($id_medecin){
        $req = $this->bdd->prepare("DELETE FROM medecin WHERE id_medecin = :id_medecin");
        $req->bindParam(':id_medecin', $id_medecin);
        return $req->execute();
    }

    // -------------------------
    // Gestion des Rendez-vous
    // -------------------------

    // Lire les rendez-vous d’un médecin
    public function readRendezVousByMedecin($id_medecin){
        $req = $this->bdd->prepare("SELECT r.*, p.id_patient, u.nom, u.prenom 
                                    FROM rendez_vous r
                                    JOIN patient p ON r.fk_id_patient = p.id_patient
                                    JOIN utilisateur u ON p.fk_id_utilisateur = u.id_utilisateur
                                    WHERE r.fk_id_medecin = :id_medecin");
        $req->bindParam(':id_medecin', $id_medecin);
        $req->execute();
        return $req->fetchAll(); 
    }

    // Mettre à jour le statut d’un rendez-vous
    public function updateStatutRendezVous($id_rdv, $statut){
        $req = $this->bdd->prepare("UPDATE rendez_vous SET statut = :statut WHERE id_rdv = :id_rdv");
        $req->bindParam(':statut', $statut);
        $req->bindParam(':id_rdv', $id_rdv);
        return $req->execute();
    }

    // -------------------------
    // Gestion des Consultations
    // -------------------------

    // Créer une consultation
    public function GetMedecinOncheckLogin($user){
       
        $req = $this->bdd->prepare("
        SELECT 
            m.id_medecin,
            m.rpps,
            m.est_conventionne,
            m.formations,
            m.langues_parlees,
            m.experiences,
            m.description,
            m.fk_id_specialite,
            s.libelle AS libelle_specialite
        FROM 
            medecin m
        JOIN 
            specialite s ON m.fk_id_specialite = s.id_specialite
        WHERE 
            m.fk_id_utilisateur = :id_utilisateur
    ");

        $req->bindparam(':id_utilisateur', $user["id_utilisateur"]);
        $req->execute();
        return $req->fetch(PDO::FETCH_ASSOC);

    }


    // Lire les consultations d’un médecin
    public function readConsultationsByMedecin($id_medecin){
        $req = $this->bdd->prepare("SELECT c.*, u.nom, u.prenom 
                                    FROM consultations c
                                    JOIN patient p ON c.fk_id_patient = p.id_patient
                                    JOIN utilisateur u ON p.fk_id_utilisateur = u.id_utilisateur
                                    WHERE c.fk_id_medecin = :id_medecin");
        $req->bindParam(':id_medecin', $id_medecin);
        $req->execute();
        return $req->fetchAll();
    }

    // -------------------------
    // Gestion des Créneaux
    // -------------------------

    // Lire les créneaux d’un médecin
    public function readCreneauxByMedecin($id_medecin){
        $req = $this->bdd->prepare("SELECT c.*, s.libelle, s.etage 
                                    FROM creneau c
                                    JOIN salle s ON c.fk_id_salle = s.id_salle
                                    WHERE c.fk_id_medecin = :id_medecin");
        $req->bindParam(':id_medecin', $id_medecin);
        $req->execute();
        return $req->fetchAll();
    }

    // -------------------------
    // Gestion des Documents Patients
    // -------------------------

    // Lire les documents d’un patient
    public function readDocumentsByPatient($id_patient){
        $req = $this->bdd->prepare("SELECT * FROM documentation WHERE fk_id_patient = :id_patient");
        $req->bindParam(':id_patient', $id_patient);
        $req->execute();
        return $req->fetchAll();
    }
}
