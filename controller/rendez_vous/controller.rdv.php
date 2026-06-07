<?php

require_once ROOT . 'bdd/bdd.php';
require_once ROOT . 'model/rendez_vous/model.rdv.php';
    
$rdvController = new RdvController($bdd);

if (isset($_POST['action'])) {

    switch ($_POST['action']) {
        case 'ajouter':
            $rdvController->create();
            break;

        case 'supprimer':
            $rdvController->delete();
            break;

        // Tu pourras ajouter d'autres cas si besoin (modifier, annuler, etc.)
    }

}

if(isset($_GET['action'])){
        
    $rdvController->updateRdv($_GET['id_rdv'], $_GET['action']);

}



class RdvController {

    private $rdv;

    function __construct($bdd) {
        $this->rdv = new Rendez_vous($bdd);
    }

    public function create() {
      //  var_dump($_POST);
    //    die();
        $this->rdv->ajouterRdv(
            $_POST['motif'], 
            $_POST['origine'], 
            $_POST['id_patient'], 
            $_POST['id_creneau']
        );
        $this->rdv->updateStatutCreneau($_POST['statut'], $_POST['id_creneau']);


        header('Location: /index.php?page=rdvPatient');
        exit;
    }

    public function delete() {
        $this->rdv->supprimerRdv($_POST['id_rdv']);

        header('Location: /index.php?page=rdvPatient');
        exit;
    }

    public function updateRdv($rdv_id, $rdvStatut){

        // 1. On met à jour le statut du RDV (confirmé, honoré, annulé...)
        $this->rdv->updateRdvStatus($rdv_id, $rdvStatut);

        // 2. Si le nouveau statut est 'annulé', on libère le créneau correspondant
        if ($rdvStatut === 'annulé') {
            $this->rdv->libererCreneauByRdv($rdv_id);
        }

        header('Location: /index.php?page=gestionRdv');
        exit;
    }

    public function updateStatutCreneau($statut, $id_creneau){

        $this->rdv->updateStatutCreneau($statut, $id_creneau);

    }

}
?>
