
DROP DATABASE IF EXISTS MaisonEco;
CREATE DATABASE IF NOT EXISTS MaisonEco;
USE MaisonEco;
DROP TABLE IF EXISTS InfoPersonne, Administrateur, Propriete,
	TypeAppartement, TypePiece, TypeSecurite,
	TypeAppareil, TypeRessource, TypeSubstance,
	Utilisateur, Appartement, Piece, Appareil,
	HistoriqueConsommation, Consommer, Produire,
	Proprietaire, Locataire;

CREATE TABLE InfoPersonne(
   idPersonne INT AUTO_INCREMENT,
   nom VARCHAR(50) ,
   dateNais DATE,
   genre CHAR(1) ,
   mail VARCHAR(50)  NOT NULL,
   numTel CHAR(10) ,
   prenom VARCHAR(50) ,
   PRIMARY KEY(idPersonne),
   UNIQUE(mail)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Administrateur(
   idPersonne INT,
   identifiant VARCHAR(50) ,
   mdp VARCHAR(50) ,
   PRIMARY KEY(idPersonne),
   FOREIGN KEY(idPersonne) REFERENCES InfoPersonne(idPersonne)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Propriete(
   idPropriete INT AUTO_INCREMENT,
   numeroRue INT,
   nomRue VARCHAR(50) ,
   codePostal INT,
   ville VARCHAR(50) ,
   nomPropriete VARCHAR(50) ,
   degreIsolation CHAR(1) ,
   PRIMARY KEY(idPropriete)
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

CREATE TABLE Utilisateur(
   idPersonne INT,
   identifiant VARCHAR(50) ,
   mdp VARCHAR(50) ,
   PRIMARY KEY(idPersonne),
   FOREIGN KEY(idPersonne) REFERENCES InfoPersonne(idPersonne)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Appartement(
   idAppartement INT AUTO_INCREMENT,
   numAppart INT,
   degreSecurite INT NOT NULL,
   typeAppart INT NOT NULL,
   idPropriete INT NOT NULL,
   PRIMARY KEY(idAppartement),
   FOREIGN KEY(degreSecurite) REFERENCES TypeSecurite(degreSecurite),
   FOREIGN KEY(typeAppart) REFERENCES TypeAppartement(typeAppart),
   FOREIGN KEY(idPropriete) REFERENCES Propriete(idPropriete)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Piece(
   idPiece INT AUTO_INCREMENT,
   typePiece INT NOT NULL,
   idAppartement INT NOT NULL,
   PRIMARY KEY(idPiece),
   FOREIGN KEY(typePiece) REFERENCES TypePiece(typePiece),
   FOREIGN KEY(idAppartement) REFERENCES Appartement(idAppartement)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Appareil(
   idAppareil INT AUTO_INCREMENT,
   nomAppareil VARCHAR(20)  NOT NULL,
   emplacement VARCHAR(50) ,
   idTypeAppareil INT NOT NULL,
   idPiece INT NOT NULL,
   PRIMARY KEY(idAppareil),
   FOREIGN KEY(idTypeAppareil) REFERENCES TypeAppareil(idTypeAppareil),
   FOREIGN KEY(idPiece) REFERENCES Piece(idPiece)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE HistoriqueConsommation(
   idConsommation INT AUTO_INCREMENT,
   dateOn DATETIME,
   dateOff DATETIME,
   idAppareil INT NOT NULL,
   PRIMARY KEY(idConsommation),
   FOREIGN KEY(idAppareil) REFERENCES Appareil(idAppareil)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Consommer(
   idTypeAppareil INT,
   typeRessource INT,
   qteMinParJour FLOAT,
   qteMaxParJour FLOAT,
   quantiteAllume FLOAT,
   PRIMARY KEY(idTypeAppareil, typeRessource),
   FOREIGN KEY(idTypeAppareil) REFERENCES TypeAppareil(idTypeAppareil),
   FOREIGN KEY(typeRessource) REFERENCES TypeRessource(typeRessource)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Produire(
   idTypeAppareil INT,
   typeSubstance INT,
   qteMinParJour FLOAT,
   qteMaxParJour FLOAT,
   quantiteAllume FLOAT,
   PRIMARY KEY(idTypeAppareil, typeSubstance),
   FOREIGN KEY(idTypeAppareil) REFERENCES TypeAppareil(idTypeAppareil),
   FOREIGN KEY(typeSubstance) REFERENCES TypeSubstance(typeSubstance)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Proprietaire(
   idPropriete INT,
   datedebutprop DATETIME,
   datefinprop DATETIME,
   idPersonne INT NOT NULL,
   PRIMARY KEY(idPropriete, datedebutprop),
   FOREIGN KEY(idPropriete) REFERENCES Propriete(idPropriete),
   FOREIGN KEY(idPersonne) REFERENCES Utilisateur(idPersonne)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Locataire(
   idAppartement INT,
   datedebutloc DATETIME,
   dateFinLoc DATETIME,
   idPersonne INT NOT NULL,
   PRIMARY KEY(idAppartement, datedebutloc),
   FOREIGN KEY(idAppartement) REFERENCES Appartement(idAppartement),
   FOREIGN KEY(idPersonne) REFERENCES Utilisateur(idPersonne)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
