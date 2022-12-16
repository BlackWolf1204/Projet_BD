
CREATE DATABASE IF NOT EXISTS MaisonEco;
USE MaisonEco;
DROP TABLE IF EXISTS InfoPersonne, Administrateur, Immeuble,
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
   numTel DECIMAL(10,0)  ,
   prenom VARCHAR(50) ,
   PRIMARY KEY(idPersonne),
   UNIQUE(mail)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Administrateur(
   idPersonne INT,
   identifiant VARCHAR(50) ,
   mdp VARCHAR(50) ,
   PRIMARY KEY(idPersonne),
   FOREIGN KEY(idPersonne) REFERENCES InfoPersonne(idPersonne)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Immeuble(
   idImmeuble INT,
   numeroRue INT,
   nomRue VARCHAR(50) ,
   codePostal INT,
   ville VARCHAR(50) ,
   nomImmeuble VARCHAR(50) ,
   degreIsolation CHAR(1) ,
   PRIMARY KEY(idImmeuble)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE TypeAppartement(
   typeAppart INT,
   libTypeAppart VARCHAR(50) ,
   PRIMARY KEY(typeAppart)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE TypePiece(
   typePiece INT,
   libTypePiece VARCHAR(50) ,
   PRIMARY KEY(typePiece)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE TypeSecurite(
   degreSecurite INT,
   nomSecurite VARCHAR(50) ,
   PRIMARY KEY(degreSecurite)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE TypeAppareil(
   idType INT,
   libTypeAppareil VARCHAR(50) ,
   PRIMARY KEY(idType)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE TypeRessource(
   typeRessource INT,
   libTypeRessource VARCHAR(50) ,
   valCritiqueConsoAppart FLOAT,
   valIdealeConsoAppart FLOAT,
   description VARCHAR(50) ,
   PRIMARY KEY(typeRessource)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE TypeSubstance(
   typeSubstance INT,
   libTypeSubstance VARCHAR(50) ,
   valCritiqueProdAppart FLOAT,
   valIdealeProdAppart FLOAT,
   description VARCHAR(50) ,
   PRIMARY KEY(typeSubstance)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Utilisateur(
   idPersonne INT,
   identifiant VARCHAR(50) ,
   mdp VARCHAR(50) ,
   PRIMARY KEY(idPersonne),
   FOREIGN KEY(idPersonne) REFERENCES InfoPersonne(idPersonne)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Appartement(
   idAppartement INT,
   numAppart INT,
   degreSecurite INT NOT NULL,
   typeAppart INT NOT NULL,
   idImmeuble INT NOT NULL,
   PRIMARY KEY(idAppartement),
   FOREIGN KEY(degreSecurite) REFERENCES TypeSecurite(degreSecurite),
   FOREIGN KEY(typeAppart) REFERENCES TypeAppartement(typeAppart),
   FOREIGN KEY(idImmeuble) REFERENCES Immeuble(idImmeuble)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Piece(
   idPiece INT,
   typePiece INT NOT NULL,
   idAppartement INT NOT NULL,
   PRIMARY KEY(idPiece),
   FOREIGN KEY(typePiece) REFERENCES TypePiece(typePiece),
   FOREIGN KEY(idAppartement) REFERENCES Appartement(idAppartement)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Appareil(
   idAppareil INT,
   emplacement VARCHAR(50) ,
   idType INT NOT NULL,
   idPiece INT NOT NULL,
   PRIMARY KEY(idAppareil),
   FOREIGN KEY(idType) REFERENCES TypeAppareil(idType),
   FOREIGN KEY(idPiece) REFERENCES Piece(idPiece)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE HistoriqueConsommation(
   idConsommation INT,
   dateOn DATETIME,
   dateOff DATETIME,
   idAppareil INT NOT NULL,
   PRIMARY KEY(idConsommation),
   FOREIGN KEY(idAppareil) REFERENCES Appareil(idAppareil)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Consommer(
   idType INT,
   typeRessource INT,
   qteMinParJour FLOAT,
   qteMaxParJour FLOAT,
   quantiteAllume FLOAT,
   PRIMARY KEY(idType, typeRessource),
   FOREIGN KEY(idType) REFERENCES TypeAppareil(idType),
   FOREIGN KEY(typeRessource) REFERENCES TypeRessource(typeRessource)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Produire(
   idType INT,
   typeSubstance INT,
   qteMinParJour FLOAT,
   qteMaxParJour FLOAT,
   quantiteAllume FLOAT,
   PRIMARY KEY(idType, typeSubstance),
   FOREIGN KEY(idType) REFERENCES TypeAppareil(idType),
   FOREIGN KEY(typeSubstance) REFERENCES TypeSubstance(typeSubstance)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Proprietaire(
   idImmeuble INT,
   datedebutprop DATETIME,
   datefinprop DATETIME,
   idPersonne INT NOT NULL,
   PRIMARY KEY(idImmeuble, datedebutprop),
   FOREIGN KEY(idImmeuble) REFERENCES Immeuble(idImmeuble),
   FOREIGN KEY(idPersonne) REFERENCES Utilisateur(idPersonne)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Locataire(
   idAppartement INT,
   datedebutloc DATETIME,
   dateFinLoc DATETIME,
   idPersonne INT NOT NULL,
   PRIMARY KEY(idAppartement, datedebutloc),
   FOREIGN KEY(idAppartement) REFERENCES Appartement(idAppartement),
   FOREIGN KEY(idPersonne) REFERENCES Utilisateur(idPersonne)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
