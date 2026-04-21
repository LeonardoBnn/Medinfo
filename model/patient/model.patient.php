<?php
require_once ROOT . "model/utilisateur/model.utilisateur.php"; 


class Patient extends Utilisateur
{
    
  
    private $bdd;

    public function __construct($bdd)
    {
        // On appelle le constructeur de Utilisateur
        parent::__construct($bdd);

        $this->bdd = $bdd;
    }
 
    // Crée un utilisateur AVEC son profil patient.
    
    public function createPatient($nom, $prenom, $email, $mdp, $tel, $date_naissance, $adresse, $num_secu, $sexe)
    {

        $role = 'Patient';

        // Création dans la table utilisateur (méthode héritée)
        $this->createUtilisateur($nom, $prenom, $email, $mdp, $tel, $role, $date_naissance);

        // On récupère l'id_utilisateur inséré juste avant
        $id_utilisateur = $this->bdd->lastInsertId();

        // 2) Création dans la table patient
        $req = $this->bdd->prepare("
            INSERT INTO patient (adresse, num_secu, sexe, fk_id_utilisateur)
            VALUES (:adresse, :num_secu, :sexe, :id_utilisateur)
        ");
        $req->bindParam(':adresse', $adresse);
        $req->bindParam(':num_secu', $num_secu);
        $req->bindParam(':sexe', $sexe);
        $req->bindParam(':id_utilisateur', $id_utilisateur);

        return $req->execute();
    }

    
    //   Lire tous les patients 
     
    public function getAllPatients(){
       
        $req = $this->bdd->prepare("
                SELECT p.*, u.*
                FROM patient p
                INNER JOIN utilisateur u ON p.fk_id_utilisateur = u.id_utilisateur
                ORDER BY u.nom, u.prenom
            ");
        $req->execute();

        return $req->fetchAll();
    }

    public function GetPatientOncheckLogin($user){
       
        $req = $this->bdd->prepare("
                SELECT 
                p.id_patient, p.adresse, p.num_secu, p.sexe
            FROM 
                patient p
            WHERE 
                p.fk_id_utilisateur = :id_utilisateur
            ");

        $req->bindparam(':id_utilisateur', $user["id_utilisateur"]);
        $req->execute();
        return $req->fetch(PDO::FETCH_ASSOC);

    }


    // mettre à jour un patient
    public function updatePatient($nom, $prenom, $email, $tel, $date_naissance, $adresse, $num_secu, $sexe, $id_patient, $id_utilisateur)
    {

        $this->updateUtilisateur($nom, $prenom, $email, $tel, $date_naissance, $id_utilisateur);

        $req = $this->bdd->prepare("
            UPDATE patient
            SET adresse = :adresse,
                num_secu = :num_secu,
                sexe = :sexe
            WHERE id_patient = :id_patient
        ");
        $req->bindParam(':adresse', $adresse);
        $req->bindParam(':num_secu', $num_secu);
        $req->bindParam(':sexe', $sexe);
        $req->bindParam(':id_patient', $id_patient);

        return $req->execute();
    }


    // Pour supprimer un patient il suffit de supprimer l'utilisateur lié à la table
    // car on a fait ON DELETE CASCADE dans la clé étrangère de utilisateur dans patient

}


?>
