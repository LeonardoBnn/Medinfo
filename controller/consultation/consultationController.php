<?php

require_once ROOT . 'bdd/bdd.php';
require_once ROOT . 'model/consultations/model.consultation.php';

if(isset($_POST['action'])){
    
    $consultationController = new ConsultationController($bdd);
    
    switch($_POST['action']){
        case 'ajouter':
            $consultationController->create();
            break;
        
    }


}

class consultationController{

    private $consultation;

    function __construct($bdd)
    {
        $this->consultation = new Consultation($bdd);
    }

    public function create(){

        $this->consultation->ajouterConsultation($_POST['compte_rendu'], $_POST['tension'], $_POST['poids'], $_POST['observations'], $_POST['id_medecin'],$_POST['id_patient']);
        header('Location:https://127.0.0.1/promo300/medinfo/index.php?page=agenda');
    }
}


?>