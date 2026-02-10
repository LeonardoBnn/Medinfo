<?php 

define('ROOT', __DIR__ . '/');

session_start();

require_once("view/commun/header.php");
$page = isset($_GET['page']) ? $_GET['page'] : 'Accueil';

switch($page){

    case 'dashboardMedecin' :
        require_once("view/medecin/dashboardMedecin.php");
        break;
    case 'gestionRdv' :
        require_once("view/medecin/gestionRdv.php");
        break;
    case 'disponibilites' :
        require_once("view/medecin/disponibilites.php");
        break;
    case 'connexion' :
        require_once("view/utilisateur/connexion.php");
        break;
    case 'inscription' :
        require_once("view/utilisateur/inscription.php");
        break;
    case 'controllerPatient' :
        require_once("controller/patient/controller.patient.php");
        break;
    case 'mdpOubliee' :
        require_once("view/utilisateur/mdpOubliee.php");
        break;
    case 'reinitMdp' :
        require_once("view/utilisateur/reinitialisationMdp.php");
        break;
    case 'accueil' :
        require_once("view/accueil.php");
        break;
    case 'prendreRdv' :
        require_once("view/patient/prendreRdv.php");
        break;
    case 'profilPatient' :
        require_once("view/patient/profilPatient.php");
        break;
    case 'agenda' :
        require_once("view/medecin/agendaMedecin.php");
        break;
    case 'ajouterConsultation' :
        require_once("view/medecin/ajouterConsultation.php");
        break;
    case 'consultationController' :
        require_once("controller/consultation/consultationController.php");
        break;
    case 'utilisateurController' :
        require_once("controller/utilisateur/controller.utilisateur.php");
        break;
    case 'consultationMedecin' :
        require_once("view/medecin/consultationMedecin.php");
        break;
    case 'controllerRdv' :
        require_once("controller/rendez_vous/controller.rdv.php");
        break;
    case 'creneauxMedecin' :
        require_once("view/medecin/creneauxMedecin.php");
        break;
    case 'rdvPatient' :
        require_once("view/patient/rdvPatient.php");
        break;


    default:
        include ('view/accueil.php');
        break;
    case 'deconnexion':
        session_destroy();
        header('Location:https://127.0.0.1/promo300/medinfo/index.php?page=accueil');
        break;
}

require_once("view/commun/footer.php");

?>