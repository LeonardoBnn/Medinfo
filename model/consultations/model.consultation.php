<?php

class Consultation{

    private $bdd;

    function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    public function ajouterConsultation($compte_rendu, $tension, $poids, $observations, $id_medecin, $id_patient){

        $req =$this->bdd->prepare("INSERT INTO consultations(compte_rendu, tension, poids, observations, fk_id_medecin, fk_id_patient) VALUES (:compte_rendu, :tension, :poids, :observations, :id_medecin, :id_patient)");

        $req->bindparam(':compte_rendu', $compte_rendu);
        $req->bindparam(':tension', $tension);
        $req->bindparam(':poids', $poids);
        $req->bindparam(':observations', $observations);
        $req->bindparam(':id_medecin', $id_medecin);
        $req->bindparam(':id_patient', $id_patient);

        return $req->execute();
    }

    public function getConsultationsMedecin($id_medecin){

        $req = $this->bdd->prepare("
                        SELECT 
                            DATE_FORMAT(c.date_saisie, '%d/%m/%Y') AS date,
                            DATE_FORMAT(c.date_saisie, '%Hh%i') AS heure,
                            c.compte_rendu, c.tension, c.poids, 
                            u.nom, u.prenom 
                        FROM consultations c
                        INNER JOIN
                            patient p ON c.fk_id_patient = p.id_patient
                        INNER JOIN
                            utilisateur u ON p.fk_id_utilisateur = u.id_utilisateur
                        WHERE c.fk_id_medecin = :id_medecin
                ");

        $req->bindparam(":id_medecin", $id_medecin);

        $req->execute();

        return $req->fetchAll();
    }

    public function getConsultationsPatient($id_utilisateur){

    }
}


?>