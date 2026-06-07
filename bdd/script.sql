DROP DATABASE IF EXISTS medinfo;

CREATE DATABASE medinfo;

USE medinfo;

-- table utilisateur
CREATE TABLE utilisateur(
   
    id_utilisateur          INT AUTO_INCREMENT PRIMARY KEY,
    nom                     VARCHAR(155)       NOT NULL,
    prenom                  VARCHAR(155)       NOT NULL,
    email                   VARCHAR(155)       NOT NULL UNIQUE,
    hash_password           VARCHAR(255)       NOT NULL,
    date_creation           TIMESTAMP          NOT NULL DEFAULT CURRENT_TIMESTAMP,
    telephone               VARCHAR(20)        NOT NULL UNIQUE,
    role                    ENUM('Admin','Patient','Medecin','Secretaire') NOT NULL,
    date_naissance          DATE               NOT NULL,
    reset_token             VARCHAR(64)        NULL,
    reset_token_expiration  DATETIME           NULL

);

-- table specialite
CREATE TABLE specialite(
   
    id_specialite INT AUTO_INCREMENT PRIMARY KEY,
    libelle       VARCHAR(155) NOT NULL

);

-- Table medecin
CREATE TABLE medecin(
   
    id_medecin        INT AUTO_INCREMENT PRIMARY KEY,
    rpps              VARCHAR(11)  NOT NULL UNIQUE,
    est_conventionne  BOOLEAN      NOT NULL DEFAULT 1,        
    formations        VARCHAR(155) NOT NULL,
    langues_parlees   VARCHAR(255) NOT NULL,
    experiences       VARCHAR(255) NOT NULL,
    description       VARCHAR(1000) NOT NULL,
    fk_id_utilisateur INT          NOT NULL,
    fk_id_specialite  INT          NOT NULL,
    FOREIGN KEY (fk_id_utilisateur) REFERENCES utilisateur(id_utilisateur),
    FOREIGN KEY (fk_id_specialite) REFERENCES specialite(id_specialite)

);

-- table patient
CREATE TABLE patient(

    id_patient      INT AUTO_INCREMENT PRIMARY KEY,
    adresse         VARCHAR(255) NOT NULL,
    num_secu        VARCHAR(15)  NOT NULL UNIQUE,
    sexe            ENUM('homme','femme') NULL,
    fk_id_utilisateur INT NOT NULL,
    FOREIGN KEY (fk_id_utilisateur) REFERENCES utilisateur(id_utilisateur) ON DELETE CASCADE

);

-- Table salle
CREATE TABLE salle(

    id_salle   INT  AUTO_INCREMENT PRIMARY KEY,
    libelle   VARCHAR(50) NOT NULL,
    etage      VARCHAR(50) NOT NULL

);

-- Table creneau
CREATE TABLE creneau(
   
    id_creneau       INT AUTO_INCREMENT PRIMARY KEY,
    date_heure_debut DATETIME NOT NULL,
    date_heure_fin   DATETIME NOT NULL,
    statut           ENUM('libre','occupe','bloque') NOT NULL,
    disponibilite    BOOLEAN NOT NULL DEFAULT 1,
    fk_id_medecin    INT NOT NULL,
    FOREIGN KEY (fk_id_medecin) REFERENCES medecin(id_medecin),
    fk_id_salle      INT NOT NULL,
    FOREIGN KEY (fk_id_salle) REFERENCES salle(id_salle)

);

-- Table rdv
CREATE TABLE rendez_vous(
   
    id_rdv        INT  AUTO_INCREMENT PRIMARY KEY,
    date_creation TIMESTAMP           NOT NULL DEFAULT CURRENT_TIMESTAMP,
    motif         VARCHAR(255) NOT NULL,
    statut        ENUM('a_confirmer','confirmé','annulé','honoré') NOT NULL DEFAULT 'a_confirmer',
    origine       VARCHAR(155) NOT NULL,
    fk_id_patient INT NOT NULL,
    fk_id_creneau INT NOT NULL,
    FOREIGN KEY (fk_id_patient) REFERENCES patient(id_patient),
    FOREIGN KEY (fk_id_creneau) REFERENCES creneau(id_creneau)

);

-- Table consultations
CREATE TABLE consultations(

    id_consultation INT  AUTO_INCREMENT PRIMARY KEY,
    date_saisie     TIMESTAMP           NOT NULL DEFAULT CURRENT_TIMESTAMP,
    compte_rendu    VARCHAR(1000)       NOT NULL,
    tension         VARCHAR(55)         NOT NULL,
    poids           VARCHAR(55)         NOT NULL,
    observations    VARCHAR(1000),
    fk_id_medecin   INT                 NOT NULL,
    fk_id_patient   INT                 NOT NULL,
    FOREIGN KEY (fk_id_medecin) REFERENCES medecin(id_medecin),
    FOREIGN KEY (fk_id_patient) REFERENCES patient(id_patient)
);

-- Table documentation
CREATE TABLE documentation(

    id_document   INT AUTO_INCREMENT PRIMARY KEY,
    document      MEDIUMBLOB         NOT NULL,
    libelle       VARCHAR(100)       NOT NULL,
    fk_id_patient INT                NOT NULL,
    FOREIGN KEY (fk_id_patient) REFERENCES patient(id_patient)

);

DELIMITER //

CREATE PROCEDURE generer_planning_medecin(
    IN p_id_medecin INT,
    IN p_id_salle INT,
    IN p_date_debut DATETIME,
    IN p_date_fin DATETIME,
    IN p_duree_minutes INT
)
BEGIN
    DECLARE v_current_time DATETIME;
    SET v_current_time = p_date_debut;

    -- Boucle tant que l'heure courante + la durée ne dépasse pas la date de fin prévue
    WHILE v_current_time < p_date_fin DO
        
        INSERT INTO creneau (
            date_heure_debut, 
            date_heure_fin, 
            statut, 
            disponibilite, 
            fk_id_medecin, 
            fk_id_salle
        ) 
        VALUES (
            v_current_time, 
            DATE_ADD(v_current_time, INTERVAL p_duree_minutes MINUTE), 
            'libre', 
            1, 
            p_id_medecin, 
            p_id_salle
        );

        -- On avance l'heure courante pour le prochain créneau
        SET v_current_time = DATE_ADD(v_current_time, INTERVAL p_duree_minutes MINUTE);
        
    END WHILE;
END //

DELIMITER ;


INSERT INTO specialite (libelle) VALUES
('Médecine générale et préventive'),
('Médecine spécialisée'),
('Dentaire'),
('Infirmerie et paramédical'),
('Imagerie médicale'),
('Laboratoire d\'analyses médicales'),
('Vaccination internationale');

INSERT INTO salle (libelle, etage) VALUES
('Box Généraliste 1', 'RDC'), ('Box Généraliste 2', 'RDC'),
('Cabinet Spécialiste 1', '1er étage'), ('Cabinet Spécialiste 2', '1er étage'),
('Fauteuil Dentaire A', '2ème étage'), ('Fauteuil Dentaire B', '2ème étage'),
('Salle Soins Infirmiers 1', 'RDC'), ('Salle Soins Infirmiers 2', 'RDC'),
('Salle Radio/Écho', 'Sous-sol'), ('Salle IRM', 'Sous-sol'),
('Labo Prélèvement 1', 'RDC'), ('Labo Prélèvement 2', 'RDC'),
('Box Vaccination A', '1er étage'), ('Box Vaccination B', '1er étage');

-- 3. UTILISATEURS (5 Secrétaires + 14 Médecins + 10 Patients = 29 Utilisateurs)
-- Secrétaires (IDs 1 à 5)
INSERT INTO utilisateur (nom, prenom, email, hash_password, telephone, role, date_naissance) VALUES 
('Lefebvre', 'Sophie', 's.lefebvre@ramsay.fr', SHA1('Sec123!'), '0102030405', 'Secretaire', '1990-05-14'),
('Moreau', 'Luc', 'l.moreau@ramsay.fr', SHA1('Sec123!'), '0102030406', 'Secretaire', '1988-11-23'),
('Garcia', 'Inès', 'i.garcia@ramsay.fr', SHA1('Sec123!'), '0102030407', 'Secretaire', '1995-02-10'),
('Roux', 'Thomas', 't.roux@ramsay.fr', SHA1('Sec123!'), '0102030408', 'Secretaire', '1992-08-30'),
('Leroy', 'Emma', 'e.leroy@ramsay.fr', SHA1('Sec123!'), '0102030409', 'Secretaire', '1998-12-05');

-- Médecins (IDs 6 à 19) - 2 par spécialité
INSERT INTO utilisateur (nom, prenom, email, hash_password, telephone, role, date_naissance) VALUES 
('Dubois', 'Jean', 'j.dubois@ramsay.fr', SHA1('Med123!'), '0611111111', 'Medecin', '1975-04-12'),
('Blanc', 'Alice', 'a.blanc@ramsay.fr', SHA1('Med123!'), '0622222222', 'Medecin', '1980-06-22'),
('Garnier', 'Paul', 'p.garnier@ramsay.fr', SHA1('Med123!'), '0633333333', 'Medecin', '1972-11-03'),
('Faure', 'Claire', 'c.faure@ramsay.fr', SHA1('Med123!'), '0644444444', 'Medecin', '1985-02-14'),
('Simon', 'Hugo', 'h.simon@ramsay.fr', SHA1('Med123!'), '0655555555', 'Medecin', '1978-09-17'),
('Michel', 'Léa', 'l.michel@ramsay.fr', SHA1('Med123!'), '0666666666', 'Medecin', '1982-01-25'),
('Perrin', 'Marc', 'm.perrin@ramsay.fr', SHA1('Med123!'), '0677777777', 'Medecin', '1990-07-08'),
('Muller', 'Julie', 'j.muller@ramsay.fr', SHA1('Med123!'), '0688888888', 'Medecin', '1987-12-19'),
('Lemoine', 'David', 'd.lemoine@ramsay.fr', SHA1('Med123!'), '0699999999', 'Medecin', '1970-03-30'),
('Roussel', 'Nina', 'n.roussel@ramsay.fr', SHA1('Med123!'), '0610101010', 'Medecin', '1989-10-11'),
('Colin', 'Pierre', 'p.colin@ramsay.fr', SHA1('Med123!'), '0620202020', 'Medecin', '1984-05-05'),
('Gautier', 'Eva', 'e.gautier@ramsay.fr', SHA1('Med123!'), '0630303030', 'Medecin', '1991-08-16'),
('Marchand', 'Lucie', 'l.marchand@ramsay.fr', SHA1('Med123!'), '0640404040', 'Medecin', '1979-04-20'),
('Richard', 'Antoine', 'a.richard@ramsay.fr', SHA1('Med123!'), '0650505050', 'Medecin', '1981-09-02');

-- Patients (IDs 20 à 29)
INSERT INTO utilisateur (nom, prenom, email, hash_password, telephone, role, date_naissance) VALUES 
('Dupont', 'Marie', 'marie.dupont@mail.com', SHA1('Pat123!'), '0712345678', 'Patient', '1990-01-01'),
('Martin', 'Bernard', 'bernard.m@mail.com', SHA1('Pat123!'), '0723456789', 'Patient', '1955-03-12'),
('Petit', 'Sophie', 'sophie.p@mail.com', SHA1('Pat123!'), '0734567890', 'Patient', '2001-07-24'),
('Robert', 'Julien', 'julien.r@mail.com', SHA1('Pat123!'), '0745678901', 'Patient', '1985-11-05'),
('Richard', 'Céline', 'celine.r@mail.com', SHA1('Pat123!'), '0756789012', 'Patient', '1992-02-18'),
('Durand', 'Alain', 'alain.d@mail.com', SHA1('Pat123!'), '0767890123', 'Patient', '1968-09-30'),
('Lefevre', 'Chloé', 'chloe.l@mail.com', SHA1('Pat123!'), '0778901234', 'Patient', '1999-04-14'),
('Morel', 'Nicolas', 'nicolas.m@mail.com', SHA1('Pat123!'), '0789012345', 'Patient', '1988-12-08'),
('Laurent', 'Manon', 'manon.l@mail.com', SHA1('Pat123!'), '0790123456', 'Patient', '1995-06-22'),
('Boucher', 'Lucas', 'lucas.b@mail.com', SHA1('Pat123!'), '0701234567', 'Patient', '2005-08-10');

-- 4. MEDECINS (Liés aux utilisateurs 6 à 19 et aux 7 spécialités)
INSERT INTO medecin (rpps, formations, langues_parlees, experiences, description, fk_id_utilisateur, fk_id_specialite) VALUES 
('10000000001', 'DES Médecine Générale', 'Français, Anglais', '10 ans cabinet', 'Médecin généraliste', 6, 1),
('10000000002', 'DES Médecine Générale', 'Français', '5 ans SOS Médecins', 'Prévention et suivi', 7, 1),
('10000000003', 'DES Cardiologie', 'Français, Italien', '15 ans CHU', 'Cardiologue', 8, 2),
('10000000004', 'DES Dermatologie', 'Français, Anglais', '8 ans cabinet privé', 'Dermatologue', 9, 2),
('10000000005', 'Chirurgie Dentaire', 'Français', '12 ans clinique', 'Orthodontie', 10, 3),
('10000000006', 'Chirurgie Dentaire', 'Français, Espagnol', '4 ans cabinet', 'Soins dentaires', 11, 3),
('10000000007', 'DE Infirmier', 'Français', '20 ans Hôpital', 'Soins courants', 12, 4),
('10000000008', 'DE Infirmier', 'Français, Arabe', '3 ans libéral', 'Prises de sang et pansements', 13, 4),
('10000000009', 'DES Radiologie', 'Français, Anglais', '10 ans clinique', 'IRM et Scanner', 14, 5),
('10000000010', 'DES Radiologie', 'Français', '7 ans Hôpital', 'Échographie', 15, 5),
('10000000011', 'Biologie médicale', 'Français', '15 ans labo', 'Analyses sanguines', 16, 6),
('10000000012', 'Biologie médicale', 'Français, Allemand', '5 ans labo', 'Microbiologie', 17, 6),
('10000000013', 'Maladies Infectieuses', 'Français, Anglais', '12 ans CHU', 'Médecine tropicale', 18, 7),
('10000000014', 'Maladies Infectieuses', 'Français', '6 ans Centre Vax', 'Vaccins voyages', 19, 7);

-- 5. PATIENTS (Liés aux utilisateurs 20 à 29)
INSERT INTO patient(adresse, num_secu, sexe, fk_id_utilisateur) VALUES
('10 Rue de la Paix 75002 Paris', '1900175123456', 'femme', 20),
('25 Avenue Foch 75016 Paris', '1550375987654', 'homme', 21),
('5 Rue des Fleurs 75015 Paris', '2010775345678', 'femme', 22),
('12 Bd Haussmann 75009 Paris', '1851175112233', 'homme', 23),
('8 Rue du Commerce 75015 Paris', '2920275445566', 'femme', 24),
('100 Rue La Fayette 75010 Paris', '1680975778899', 'homme', 25),
('45 Bd Saint-Michel 75005 Paris', '2990475990011', 'femme', 26),
('3 Place d Italie 75013 Paris', '1881275223344', 'homme', 27),
('18 Rue Oberkampf 75011 Paris', '2950675556677', 'femme', 28),
('90 Bd de Clichy 75018 Paris', '1050875889900', 'homme', 29);

-- 6. CRÉNEAUX, RDV ET CONSULTATIONS PASSÉS (Pour l'historique)
-- Création de 3 créneaux dans le passé (Mai 2026)
INSERT INTO creneau (date_heure_debut, date_heure_fin, statut, disponibilite, fk_id_medecin, fk_id_salle) VALUES 
('2026-05-10 09:00:00', '2026-05-10 09:30:00', 'occupe', 0, 1, 1), -- Méd Généraliste
('2026-05-15 14:00:00', '2026-05-15 14:30:00', 'occupe', 0, 5, 5), -- Dentiste
('2026-05-20 10:00:00', '2026-05-20 10:30:00', 'occupe', 0, 13, 13); -- Vaccin

-- Prise des 3 RDV passés
INSERT INTO rendez_vous (date_creation, motif, statut, origine, fk_id_patient, fk_id_creneau) VALUES
('2026-05-01 10:00:00', 'Fièvre et toux', 'honoré', 'Plateforme Web', 1, 1),
('2026-05-05 11:00:00', 'Détartrage', 'honoré', 'Plateforme Web', 2, 2),
('2026-05-10 09:00:00', 'Vaccin Fièvre Jaune', 'honoré', 'Plateforme Web', 3, 3);

-- Consultations complétées pour ces 3 RDV
INSERT INTO consultations (date_saisie, compte_rendu, tension, poids, observations, fk_id_medecin, fk_id_patient) VALUES 
('2026-05-10 09:35:00', 'Angine bactérienne diagnostiquée. Prescription antibiotiques.', '12/8', '65kg', 'Repos 3 jours.', 1, 1),
('2026-05-15 14:40:00', 'Détartrage complet effectué. Pas de caries.', '-', '-', 'Brossage 3x/jour recommandé.', 5, 2),
('2026-05-20 10:35:00', 'Injection vaccin Fièvre Jaune réalisée sans réaction allergique.', '13/8', '70kg', 'Carnet de vaccination mis à jour.', 13, 3);

-- 7. CRÉNEAUX FUTURS (Semaine de l'examen du 08/06/2026 au 12/06/2026)
-- Pour éviter que ta procédure ne génère des créneaux la nuit, on l'appelle jour par jour (de 09h à 18h) pour 3 médecins pour l'exemple
-- Si tu veux le faire pour les 14, tu peux copier-coller ces lignes en changeant l'ID du médecin.

-- Médecin 1 (Généraliste - Salle 1)
CALL generer_planning_medecin(1, 1, '2026-06-08 09:00:00', '2026-06-08 18:00:00', 30);
CALL generer_planning_medecin(1, 1, '2026-06-09 09:00:00', '2026-06-09 18:00:00', 30);
CALL generer_planning_medecin(1, 1, '2026-06-10 09:00:00', '2026-06-10 18:00:00', 30);
CALL generer_planning_medecin(1, 1, '2026-06-11 09:00:00', '2026-06-11 18:00:00', 30);
CALL generer_planning_medecin(1, 1, '2026-06-12 09:00:00', '2026-06-12 18:00:00', 30);

-- Médecin 3 (Cardiologue - Salle 3)
CALL generer_planning_medecin(3, 3, '2026-06-08 09:00:00', '2026-06-08 18:00:00', 30);
CALL generer_planning_medecin(3, 3, '2026-06-09 09:00:00', '2026-06-09 18:00:00', 30);
CALL generer_planning_medecin(3, 3, '2026-06-10 09:00:00', '2026-06-10 18:00:00', 30);

-- Médecin 5 (Dentiste - Salle 5)
CALL generer_planning_medecin(5, 5, '2026-06-08 09:00:00', '2026-06-08 18:00:00', 30);
CALL generer_planning_medecin(5, 5, '2026-06-11 09:00:00', '2026-06-11 18:00:00', 30);

-- 8. QUELQUES RDV FUTURS POUR LA SEMAINE (En bloquant les créneaux générés ci-dessus)
-- On bloque manuellement quelques créneaux (en assumant que les IDs des créneaux de Médecin 1 commencent à 4 suite à nos inserts)
UPDATE creneau SET statut = 'occupe', disponibilite = 0 WHERE id_creneau IN (4, 5, 25);

INSERT INTO rendez_vous (motif, statut, origine, fk_id_patient, fk_id_creneau) VALUES
('Renouvellement ordonnance', 'confirmé', 'Plateforme Web', 1, 4),
('Bilan sanguin annuel', 'a_confirmer', 'Plateforme Web', 4, 5),
('Douleur thoracique', 'confirmé', 'Plateforme Web', 5, 25);