<?php

class Utilisateur{

    private $bdd;

    function __construct($bdd)
    {
        $this->bdd=$bdd;
    }


    public function createUtilisateur($nom, $prenom, $email, $mdp, $tel, $role, $date_naissance){

        $hashmdp = sha1($mdp);
        $req = $this->bdd->prepare("INSERT INTO utilisateur(nom, prenom, email, hash_password, telephone, role, date_naissance) VALUES (:nom, :prenom, :email, :mdp, :tel, :role, :date_naissance)");
        $req->bindParam(':nom', $nom);
        $req->bindParam(':prenom', $prenom);
        $req->bindParam(':email', $email);
        $req->bindParam(':mdp', $hashmdp);
        $req->bindParam(':tel', $tel);
        $req->bindParam(':role', $role);
        $req->bindParam(':date_naissance', $date_naissance);
               
        return $req->execute();
    }

    public function checkLogin($email, $mdp){
        $hashmdp = sha1($mdp);
        $req = $this->bdd->prepare("SELECT * FROM utilisateur WHERE email= :email AND hash_password= :mdp");
        $req->bindParam(':email', $email);
        $req->bindParam(':mdp', $hashmdp);  
        $req->execute();
        return $req->fetch(PDO::FETCH_ASSOC);
    }


    public function readUtilisateur(){

        $req = $this->bdd->prepare("SELECT * FROM utilisateur");
        $req->execute();

        return $req->fetchAll();
    }

    public function updateUtilisateur($nom, $prenom, $email, $tel, $id_utilisateur){

        $req = $this->bdd->prepare("UPDATE utilisateur SET nom = :nom, prenom = :prenom, email= :email, telephone = :tel WHERE id_utilisateur = :id_utilisateur");
        $req->bindParam(':nom', $nom);
        $req->bindParam(':prenom', $prenom);
        $req->bindParam(':email', $email);
        $req->bindParam(':tel', $tel);
        $req->bindParam(':id_utilisateur', $id_utilisateur);

        return $req->execute();
    }

    public function deleteUtilisateur($id_utilisateur){

        $req = $this->bdd->prepare("DELETE FROM utilisateur WHERE id_utilisateur = :id_utilisateur");
        $req->bindParam(':id_utilisateur', $id_utilisateur);

        return $req->execute();
    }

    //fonction pour la gestion du reset du mdp
    public function createResetToken($email)
    {
        // 1) Vérifier que l'utilisateur existe
        $req = $this->bdd->prepare("SELECT id_utilisateur FROM utilisateur WHERE email = :email");
        $req->bindParam(':email', $email);
        $req->execute();
        $user = $req->fetch();

        if (!$user) {
            // Aucun utilisateur avec cet email
            return false;
        }

        // 2) Générer un token (32 caractères hexadécimaux)
        $token = bin2hex(random_bytes(16));

        // 3) Définir une date d'expiration (ex : +1 heure)
        $expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // 4) Sauvegarder en base
        $update = $this->bdd->prepare(" UPDATE utilisateur SET reset_token = :token, reset_token_expiration = :expiration WHERE email = :email");

        $update->bindParam(':token', $token);
        $update->bindParam(':expiration', $expiration);
        $update->bindParam(':email', $email);

        if ($update->execute()) {
            // On renvoie le token au contrôleur
            return $token;
        } else {
            return false;
        }
    }

    public function verifyResetToken($token)
    {
        // Vérifier en base : token + expiration non dépassée
        $req = $this->bdd->prepare("SELECT id_utilisateur FROM utilisateur WHERE reset_token = :token AND reset_token_expiration > NOW()");
        $req->bindParam(':token', $token);
        $req->execute();

        return $req->fetch();
    }

    public function updatePassword($token, $nouveauMdp)
    {
        $hash = sha1($nouveauMdp);

        // On met à jour le mdp + on supprime le token pour qu'il soit à usage unique
        $req = $this->bdd->prepare("
            UPDATE utilisateur
            SET hash_password = :mdp,
                reset_token = NULL,
                reset_token_expiration = NULL
            WHERE reset_token = :token
        ");

        $req->bindParam(':mdp', $hash);
        $req->bindParam(':token', $token);

        return $req->execute();
    }

}   