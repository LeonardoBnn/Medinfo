<?php

require_once ROOT . '/bdd/bdd.php';

require_once ROOT . 'model/medecin/model.medecin.php';

require_once ROOT . 'model/patient/model.patient.php';

require_once ROOT . 'model/utilisateur/model.utilisateur.php';



if(isset($_POST['action'])){
    $utilisateurController = new Utilisateur($bdd);
    $user = $utilisateurController->checkLogin($_POST['email'], $_POST['mdp']);
    if($user){
        switch ($user['role']) {
        case 'Patient':
            $patientController = new Patient($bdd);
            $patient = array_merge($user, $patientController->GetPatientOncheckLogin($user));
            if($patient){
                session_start();
                $_SESSION['user'] = $patient;
                header('Location: /index.php?page=accueil'); 
            }
            break;            
            
        case 'Medecin':
            $medecinController = new Medecin($bdd);
            $medecin = array_merge($user, $medecinController->GetMedecinOncheckLogin($user));
            if($medecin){
                session_start();
                $_SESSION['user'] = $medecin;
                header('Location: /index.php?page=accueil'); 
            }
            break;            
    }
    }else{
        $_SESSION['login_error'] = "Identifiants incorrects. Veuillez réessayer.";
        header('Location: /index.php?page=connexion');
        exit;
    }
}

?>
