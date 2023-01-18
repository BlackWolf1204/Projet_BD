
DROP DATABASE IF EXISTS MaisonEco;
CREATE DATABASE IF NOT EXISTS MaisonEco;
USE MaisonEco;
DROP TRIGGER IF EXISTS VerifDonneesInfoPersonne;
DROP TRIGGER IF EXISTS VerifDonneesUtilisateur;
DROP TRIGGER IF EXISTS VerifDonneesAdministrateur;
DROP TRIGGER IF EXISTS VerifDonneesVille;
DROP TRIGGER IF EXISTS VerifDonneesAdresse;
DROP TRIGGER IF EXISTS VerifDonneesAppartement;
DROP TRIGGER IF EXISTS SuppressionInfoPersonne;
DROP VIEW IF EXISTS ProprieteAdresse, DernierLocataire, LocataireActuel, ProprietaireActuel;
DROP TABLE IF EXISTS InfoPersonne, Administrateur, Propriete,
	TypeAppartement, TypePiece, TypeSecurite,
	TypeAppareil, TypeRessource, TypeSubstance,
	Utilisateur, Appartement, Piece, Appareil,
	HistoriqueConsommation, Consommer, Produire,
	Proprietaire, Locataire;

CREATE TABLE InfoPersonne(
   idPersonne INT AUTO_INCREMENT,
   nom VARCHAR(50)  NOT NULL,
   dateNais DATE,
   genre CHAR(1) ,
   mail VARCHAR(50)  NOT NULL,
   numTel CHAR(10) ,
   prenom VARCHAR(50)  NOT NULL,
   PRIMARY KEY(idPersonne),
   UNIQUE(mail)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Administrateur(
   idPersonne INT,
   identifiant VARCHAR(50)  NOT NULL,
   mdp VARCHAR(50)  NOT NULL,
   dateCreation DATE NOT NULL,
   PRIMARY KEY(idPersonne),
   FOREIGN KEY(idPersonne) REFERENCES InfoPersonne(idPersonne)
        ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE TypeAppartement(
   typeAppart INT,
   libTypeAppart VARCHAR(50) ,
   nbPieces INT,
   PRIMARY KEY(typeAppart)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE TypePiece(
   typePiece INT,
   libTypePiece VARCHAR(50) ,
   PRIMARY KEY(typePiece)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE TypeSecurite(
   degreSecurite INT,
   nomSecurite VARCHAR(50) ,
   PRIMARY KEY(degreSecurite)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE TypeAppareil(
   idTypeAppareil INT AUTO_INCREMENT,
   libTypeAppareil VARCHAR(50) ,
   VideoEconomie VARCHAR(150) ,
   PRIMARY KEY(idTypeAppareil)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE TypeRessource(
   typeRessource INT AUTO_INCREMENT,
   libTypeRessource VARCHAR(50) ,
   valCritiqueConsoAppart FLOAT,
   valIdealeConsoAppart FLOAT,
   description VARCHAR(50) ,
   PRIMARY KEY(typeRessource)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE TypeSubstance(
   typeSubstance INT AUTO_INCREMENT,
   libTypeSubstance VARCHAR(50) ,
   valCritiqueProdAppart FLOAT,
   valIdealeProdAppart FLOAT,
   description VARCHAR(50) ,
   PRIMARY KEY(typeSubstance)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Region(
   idRegion INT,
   nomRegion VARCHAR(50)  NOT NULL,
   PRIMARY KEY(idRegion),
   UNIQUE(nomRegion)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Departement(
   numDepartement INT,
   nomDepartement VARCHAR(50)  NOT NULL,
   idRegion INT NOT NULL,
   PRIMARY KEY(numDepartement),
   UNIQUE(nomDepartement),
   FOREIGN KEY(idRegion) REFERENCES Region(idRegion)
        ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Ville(
   idVille INT AUTO_INCREMENT,
   nomVille VARCHAR(50)  NOT NULL,
   codePostal VARCHAR(5)  NOT NULL,
   numDepartement INT NOT NULL,
   PRIMARY KEY(idVille),
   FOREIGN KEY(numDepartement) REFERENCES Departement(numDepartement)
        ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Rue(
   idRue INT AUTO_INCREMENT,
   nomRue VARCHAR(50)  NOT NULL,
   idVille INT NOT NULL,
   PRIMARY KEY(idRue),
   FOREIGN KEY(idVille) REFERENCES Ville(idVille)
        ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Adresse(
   idAdresse INT AUTO_INCREMENT,
   numeroRue INT NOT NULL,
   idRue INT NOT NULL,
   PRIMARY KEY(idAdresse),
   FOREIGN KEY(idRue) REFERENCES Rue(idRue)
        ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Utilisateur(
   idPersonne INT,
   identifiant VARCHAR(50)  NOT NULL,
   mdp VARCHAR(50)  NOT NULL,
   dateCreation DATE NOT NULL,
   PRIMARY KEY(idPersonne),
   FOREIGN KEY(idPersonne) REFERENCES InfoPersonne(idPersonne)
        ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Propriete(
   idPropriete INT AUTO_INCREMENT,
   nomPropriete VARCHAR(50) ,
   degreIsolation CHAR(1) ,
   idAdresse INT NOT NULL,
   PRIMARY KEY(idPropriete),
   FOREIGN KEY(idAdresse) REFERENCES Adresse(idAdresse)
        ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Créer une vue avec la propriété et son adresse
CREATE VIEW ProprieteAdresse AS
SELECT Propriete.idPropriete, Propriete.nomPropriete, Propriete.degreIsolation, Adresse.numeroRue, Rue.nomRue, Ville.nomVille, Ville.codePostal, Departement.nomDepartement, Region.nomRegion
FROM Propriete
NATURAL JOIN Adresse
NATURAL JOIN Rue
NATURAL JOIN Ville
NATURAL JOIN Departement
NATURAL JOIN Region;

CREATE TABLE Appartement(
   idAppartement INT AUTO_INCREMENT,
   numAppart INT,
   degreSecurite INT NOT NULL,
   typeAppart INT NOT NULL,
   idPropriete INT NOT NULL,
   PRIMARY KEY(idAppartement),
   FOREIGN KEY(degreSecurite) REFERENCES TypeSecurite(degreSecurite)
        ON DELETE CASCADE,
   FOREIGN KEY(typeAppart) REFERENCES TypeAppartement(typeAppart)
        ON DELETE CASCADE,
   FOREIGN KEY(idPropriete) REFERENCES Propriete(idPropriete)
        ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Piece(
   idPiece INT AUTO_INCREMENT,
   typePiece INT NOT NULL,
   idAppartement INT NOT NULL,
   PRIMARY KEY(idPiece),
   FOREIGN KEY(typePiece) REFERENCES TypePiece(typePiece),
   FOREIGN KEY(idAppartement) REFERENCES Appartement(idAppartement)
        ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Appareil(
   idAppareil INT AUTO_INCREMENT,
   nomAppareil VARCHAR(50)  NOT NULL,
   emplacement VARCHAR(200) ,
   idTypeAppareil INT NOT NULL,
   idPiece INT NOT NULL,
   PRIMARY KEY(idAppareil),
   FOREIGN KEY(idTypeAppareil) REFERENCES TypeAppareil(idTypeAppareil)
        ON DELETE CASCADE,
   FOREIGN KEY(idPiece) REFERENCES Piece(idPiece)
        ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE HistoriqueConsommation(
   idConsommation INT AUTO_INCREMENT,
   dateOn DATETIME,
   dateOff DATETIME,
   idAppareil INT NOT NULL,
   PRIMARY KEY(idConsommation),
   FOREIGN KEY(idAppareil) REFERENCES Appareil(idAppareil)
        ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Consommer(
   idTypeAppareil INT,
   typeRessource INT,
   qteMinParJour FLOAT,
   qteMaxParJour FLOAT,
   quantiteAllume FLOAT,
   PRIMARY KEY(idTypeAppareil, typeRessource),
   FOREIGN KEY(idTypeAppareil) REFERENCES TypeAppareil(idTypeAppareil)
        ON DELETE CASCADE,
   FOREIGN KEY(typeRessource) REFERENCES TypeRessource(typeRessource)
        ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Produire(
   idTypeAppareil INT,
   typeSubstance INT,
   qteMinParJour FLOAT,
   qteMaxParJour FLOAT,
   quantiteAllume FLOAT,
   PRIMARY KEY(idTypeAppareil, typeSubstance),
   FOREIGN KEY(idTypeAppareil) REFERENCES TypeAppareil(idTypeAppareil)
        ON DELETE CASCADE,
   FOREIGN KEY(typeSubstance) REFERENCES TypeSubstance(typeSubstance)
        ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Proprietaire(
   idPropriete INT,
   datedebutprop DATETIME,
   datefinprop DATETIME,
   idPersonne INT NOT NULL,
   PRIMARY KEY(idPropriete, datedebutprop),
   FOREIGN KEY(idPropriete) REFERENCES Propriete(idPropriete)
        ON DELETE CASCADE,
   FOREIGN KEY(idPersonne) REFERENCES Utilisateur(idPersonne)
        ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE VIEW DernierProprietaire AS
SELECT datedebutprop, datefinprop, idPropriete, idPersonne AS idProprietaire, nom AS nomProprietaire, prenom AS prenomProprietaire
FROM Proprietaire
NATURAL JOIN Utilisateur
NATURAL JOIN InfoPersonne
WHERE datedebutprop = (SELECT MAX(datedebutprop) FROM Proprietaire AS P WHERE P.idPropriete = Proprietaire.idPropriete);

CREATE VIEW ProprietaireActuel AS
SELECT datedebutprop, datefinprop, idPropriete, idPersonne AS idProprietaire, nom AS nomProprietaire, prenom AS prenomProprietaire
FROM Proprietaire
NATURAL JOIN Utilisateur
NATURAL JOIN InfoPersonne
WHERE datefinprop IS NULL;

CREATE TABLE Locataire(
   idAppartement INT,
   datedebutloc DATETIME,
   dateFinLoc DATETIME,
   idPersonne INT NOT NULL,
   nbHabitants INT,
   PRIMARY KEY(idAppartement, datedebutloc),
   FOREIGN KEY(idAppartement) REFERENCES Appartement(idAppartement)
        ON DELETE CASCADE,
   FOREIGN KEY(idPersonne) REFERENCES Utilisateur(idPersonne)
        ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE VIEW DernierLocataire AS
SELECT idAppartement, datedebutloc, dateFinLoc, idPersonne AS idLocataire, nbHabitants, nom AS nomLocataire, prenom AS prenomLocataire
FROM Locataire
NATURAL JOIN Utilisateur
NATURAL JOIN InfoPersonne
WHERE datedebutloc = (SELECT MAX(datedebutloc) FROM Locataire AS L WHERE L.idAppartement = Locataire.idAppartement);

CREATE VIEW LocataireActuel AS
SELECT idAppartement, datedebutloc, dateFinLoc, idPersonne AS idLocataire, nbHabitants, nom AS nomLocataire, prenom AS prenomLocataire
FROM Locataire
NATURAL JOIN Utilisateur
NATURAL JOIN InfoPersonne
WHERE dateFinLoc IS NULL;


-- Génération des TIGGER :
DELIMITER//

-- Empêcher la création d'un compte pour les données invalides :
--  - pour une personne de moins de 18 ans
--  - pour un numéro de téléphone invalide
CREATE TRIGGER VerifDonneesInfoPersonne
BEFORE INSERT ON InfoPersonne
FOR EACH ROW
BEGIN
    IF (NEW.dateNais > DATE_SUB(CURDATE(), INTERVAL 18 YEAR)) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Vous devez avoir plus de 18 ans pour créer un compte';
    END IF;
    IF (NEW.numTel NOT REGEXP '^0[1-9][0-9]{8}$') THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Le numéro de téléphone doit être composé de 10 chiffres et commencer par 0';
    END IF;
END;

-- Empêcher la création et modification d'un compte Utilisateur et Administrateur pour les données invalides :
--  - pour un identifiant déjà utilisé
--  - pour un mot de passe ne correspondant pas à un hash
CREATE TRIGGER VerifDonneesUtilisateur
BEFORE INSERT ON Utilisateur
FOR EACH ROW
BEGIN
    IF (NEW.identifiant IN (SELECT identifiant FROM Utilisateur)) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cet identifiant est déjà utilisé';
    END IF;
    IF (NEW.mdp NOT REGEXP '^[a-zA-Z0-9]{20,}$') THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Le mot de passe n''est pas valide';
    END IF;
END;

CREATE TRIGGER VerifDonneesAdministrateur
BEFORE INSERT ON Administrateur
FOR EACH ROW
BEGIN
    IF (NEW.identifiant IN (SELECT identifiant FROM Administrateur)) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cet identifiant est déjà utilisé';
    END IF;
    IF (NEW.mdp NOT REGEXP '^[a-zA-Z0-9]{20,}$') THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Le mot de passe n''est pas valide';
    END IF;
END;

-- Empêcher la création d'une ville dont les données ne sont pas valides :
--  - Un code postal doit être composé de 5 chiffres et doit commencer par le numéro du département
CREATE TRIGGER VerifDonneesVille
BEFORE INSERT ON Ville
FOR EACH ROW
BEGIN
    IF (NEW.codePostal NOT REGEXP '^[0-9]{5}$') THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Le code postal doit être composé de 5 chiffres';
    END IF;
    -- Les 2 premiers caractères du code postal correspondent au numéro du département
    IF (NEW.numDepartement NOT LIKE CONCAT(SUBSTRING(NEW.codePostal, 1, 2), '%')) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Le code postal doit commencer par le numéro du département';
    END IF;
END;

-- Empêcher la création d'une adresse dont les données ne sont pas valides :
--  - Le numéro de rue doit être un entier positif
CREATE TRIGGER VerifDonneesAdresse
BEFORE INSERT ON Adresse
FOR EACH ROW
BEGIN
    IF (NEW.numeroRue NOT REGEXP '^[1-9][0-9]*$') THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Le numéro de rue doit être un entier positif';
    END IF;
END;

-- Empêcher la création d'un appartement dont les données ne sont pas valides :
--  - Le numéro de l'appartement doit être un entier positif
CREATE TRIGGER VerifDonneesAppartement
BEFORE INSERT ON Appartement
FOR EACH ROW
BEGIN
    IF (NEW.numAppart NOT REGEXP '^[1-9][0-9]*$') THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Le numéro de l''appartement doit être un entier positif';
    END IF;
END;

-- Supprimer le compte Utilisateur et Administrateur lors de la suppression d'une personne d'InfoPersonne
-- Mettre fin aux propriétés et aux locations de l'appartement lors de la suppression
-- CREATE TRIGGER SuppressionInfoPersonne
-- AFTER DELETE ON InfoPersonne
-- FOR EACH ROW
-- BEGIN
--     DELETE FROM Utilisateur WHERE idPersonne = OLD.idPersonne;
--     DELETE FROM Administrateur WHERE idPersonne = OLD.idPersonne;
--     UPDATE Proprietaire SET datefinprop = CURDATE() WHERE Proprietaire.idPersonne = OLD.idPersonne AND datefinprop IS NULL;
--     UPDATE Proprietaire SET idPersonne = NULL WHERE idPersonne = OLD.idPersonne;
--     UPDATE Locataire SET dateFinLoc = CURDATE() WHERE Locataire.idPersonne = OLD.idPersonne AND dateFinLoc IS NULL;
--     UPDATE Locataire SET idPersonne = NULL WHERE idPersonne = OLD.idPersonne;
-- END;

-- DROP TRIGGER IF EXISTS SuppressionInfoPersonne;
-- DELETE FROM InfoPersonne WHERE idPersonne = 2;
-- SELECT * FROM utilisateur;
-- SELECT * FROM proprietaire;
-- SELECT * FROM locataire;
-- Problème : idPersonne de Porprietaire et Locataire ne peut pas être null (donc suppression directe)

//
DELIMITER;