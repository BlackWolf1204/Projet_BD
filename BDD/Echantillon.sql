-- Données fictives

-- Info personne (idPersonne, nom, dateNaissance, genre, email, tel, prenom)
INSERT INTO InfoPersonne VALUES (1, 'MARTIN', '1990-01-01', 'M', 'gabriel9854@gmail.com', '0695867428', 'Gabriel');
INSERT INTO InfoPersonne VALUES (2, 'ETIENNE', '1997-01-01', 'M', 'Adam7474@gmail.com', '0659852674', 'Adam');
INSERT INTO InfoPersonne VALUES (3, 'MALLET', '1995-01-01', 'F', 'AlaineE9586@gmail.com', '06359824', 'Alaine');
INSERT INTO InfoPersonne VALUES (4, 'LAURENT', '1999-01-01', 'M', 'Lucas22@gmail.com', '0639356827', 'Lucas');
INSERT INTO InfoPersonne VALUES (5, 'PETIT', '1997-01-01', 'F', 'Doriane562@gmail.com', '0695847233', 'Doriane');

-- Administrateur (idPersonne, login, mdp)
INSERT INTO Administrateur VALUES (1, 'Martin_Gab', 'yRTX7pf6');
INSERT INTO Administrateur VALUES (4, 'Laurent_Lucas', 'TgeiRD8v7');

-- Utilisateur (idPersonne, login, mdp)
INSERT INTO Utilisateur VALUES (2, 'Adam7474', '97Edmf');
INSERT INTO Utilisateur VALUES (3, 'Alaine8', 'Ht5e9d');
INSERT INTO Utilisateur VALUES (4, 'Lucas', 'zk2C8mM');
INSERT INTO Utilisateur VALUES (5, 'Doriane', 'rGh9L2m');

-- Propriété (idPropriete, numeroRue, nomRue, codePostal, ville, nom, degréIsolation)
INSERT INTO Propriete VALUES (1, 4, 'BD de chinon', 3700, 'Tours', 'Tranquillité', 'C');
INSERT INTO Propriete VALUES (2, 16, 'Rue Saint-Lazara', 70123, 'Paris', 'Laval', 'B');
INSERT INTO Propriete VALUES (3, 10, 'Rue du Ressort', 63000, 'Clermont-Ferrand', 'Résidence du Parc', 'C');

-- Type sécurité (typeSécurité, libéllé)
INSERT INTO TypeSecurite VALUES (1, 'Faible');
INSERT INTO TypeSecurite VALUES (2, 'Moyen');
INSERT INTO TypeSecurite VALUES (3, 'Fort');

-- Type appartement (typeAppart, libéllé, nbPieces)
INSERT INTO TypeAppartement VALUES (1, 'T1', 1);
INSERT INTO TypeAppartement VALUES (2, 'T1 bis', 1);
INSERT INTO TypeAppartement VALUES (3, 'T2', 2);
INSERT INTO TypeAppartement VALUES (4, 'T2 bis', 2);
INSERT INTO TypeAppartement VALUES (5, 'T3', 3);
INSERT INTO TypeAppartement VALUES (6, 'T3 bis', 3);
INSERT INTO TypeAppartement VALUES (7, 'T4', 4);
INSERT INTO TypeAppartement VALUES (8, 'T3 T4', 3);
INSERT INTO TypeAppartement VALUES (9, 'T5', 5);
INSERT INTO TypeAppartement VALUES (10, 'T6', 6);
INSERT INTO TypeAppartement VALUES (11, 'T7', 7);
INSERT INTO TypeAppartement VALUES (12, 'Studio', 1);
INSERT INTO TypeAppartement VALUES (13, 'Duplex', 2);
INSERT INTO TypeAppartement VALUES (14, 'Triplex', 3);
INSERT INTO TypeAppartement VALUES (15, 'Souplex', 1);
INSERT INTO TypeAppartement VALUES (16, 'Loft', 1);
INSERT INTO TypeAppartement VALUES (17, 'F1', 1);
INSERT INTO TypeAppartement VALUES (18, 'F2', 2);
INSERT INTO TypeAppartement VALUES (19, 'F3', 3);
INSERT INTO TypeAppartement VALUES (20, 'F4', 4);
INSERT INTO TypeAppartement VALUES (21, 'F5', 5);
INSERT INTO TypeAppartement VALUES (22, 'F6', 6);
INSERT INTO TypeAppartement VALUES (23, 'P1', 1);
INSERT INTO TypeAppartement VALUES (24, 'P2', 2);
INSERT INTO TypeAppartement VALUES (25, 'P3', 3);
INSERT INTO TypeAppartement VALUES (26, 'P4', 4);
INSERT INTO TypeAppartement VALUES (27, 'P5', 5);
INSERT INTO TypeAppartement VALUES (28, 'P6', 6);

-- Appartement (idAppartement, numAppart, degreSecurite, typeAppart, idPropriete)
INSERT INTO Appartement VALUES (1, 2, 1, 3, 3);
INSERT INTO Appartement VALUES (2, 7, 2, 1, 1);
INSERT INTO Appartement VALUES (3, 9, 3, 2, 2);
INSERT INTO Appartement VALUES (4, 10, 2, 2, 2);

-- Type pièce (typePiece, libéllé)
INSERT INTO TypePiece VALUES (1, 'cuisine');
INSERT INTO TypePiece VALUES (2, 'salon');
INSERT INTO TypePiece VALUES (3, 'salle à manger');
INSERT INTO TypePiece VALUES (4, 'piece principale');

-- Pièce (idPiece, typePiece, idAppartement)
INSERT INTO Piece VALUES (1, 2, 1); -- salon
INSERT INTO Piece VALUES (2, 1, 1); -- cuisine
INSERT INTO Piece VALUES (3, 4, 3); -- pièce principale
INSERT INTO Piece VALUES (4, 4, 4); -- pièce principale

-- Propriétaire (idPropriete, datedebutprop, datefinprop, idPersonne)
INSERT INTO Proprietaire VALUES (1, '2017-06-18', '2025-02-25', 3);
INSERT INTO Proprietaire VALUES (2, '2019-09-03', '2024-09-15', 2);
INSERT INTO Proprietaire VALUES (3, '2021-04-27', '2027-02-09', 5);

-- Locataire (idAppartement, datedebutloc, dateFinLoc, idPersonne)
INSERT INTO Locataire VALUES (1, '2022-08-21', '2024-09-04', 5);
INSERT INTO Locataire VALUES (3, '2021-02-14', '2023-02-19', 2);
INSERT INTO Locataire VALUES (4, '2021-11-17', '2024-01-01', 4);

-- TypeApparreil (idTypeAppareil, libéllé)
INSERT INTO TypeAppareil VALUES (1, 'chauffage éléctrique');
INSERT INTO TypeAppareil VALUES (2, 'réfrigérateur');
INSERT INTO TypeAppareil VALUES (3, 'lampe');
INSERT INTO TypeAppareil VALUES (4, 'aspirateur');
INSERT INTO TypeAppareil VALUES (5, 'plaques de cuisson');
INSERT INTO TypeAppareil VALUES (6, 'télévision');
INSERT INTO TypeAppareil VALUES (7, 'chauffage au gaz');

-- Appareil (idAppareil, nomAppareil, emplacement, idTypeAppareil, idPiece)
INSERT INTO Appareil VALUES (1, "Chauffage cuisine", "Sous la fenêtre", 1, 2); -- chauffage éléctrique, cuisine
INSERT INTO Appareil VALUES (2, "La lampe du séjour", "Au milieu du plafond", 3, 3); -- lampe, piece principale
INSERT INTO Appareil VALUES (3, "L'aspirateur", "Sous les mantaux", 4, 3); -- aspirateur, piece principale
INSERT INTO Appareil VALUES (4, "La télé", "Devant le canapé", 6, 1); -- télévision, salon

-- TypeRessource (idTypeRessource, libéllé, valCritiqueConsoAppart, valIdealeConsoAppart, description)
INSERT INTO TypeRessource VALUES (1, 'électricité', 50000, 5000, 'électricité...'); -- Wh / jour / foyer
INSERT INTO TypeRessource VALUES (2, 'gaz', 50000, 13000, 'le gaz...'); -- Wh / jour / foyer
INSERT INTO TypeRessource VALUES (3, 'eau', 2, 0.7, "l'eau..."); -- m3 / jour / foyer

-- Consommer (idTypeAppareil, typeRessource, qteMinParJour, qteMaxParJour, quantiteAllume)
INSERT INTO Consommer VALUES (1, 1, 500, 1400, 1150); -- chauffage élec
INSERT INTO Consommer VALUES (2, 1, 100, 1000, 150); -- réfrigérateur
INSERT INTO Consommer VALUES (3, 1, 0, 1800, 75); -- lampe
INSERT INTO Consommer VALUES (4, 1, 0, 200, 150); -- aspirateur
INSERT INTO Consommer VALUES (5, 1, 0, 300, 250); -- plaques de cuisson
INSERT INTO Consommer VALUES (6, 1, 0, 1200, 50); -- télévision
INSERT INTO Consommer VALUES (7, 2, 0, 1000, 500); -- chauffage au gaz

-- TypeSubstance (idTypeSubstance, libéllé, valCritiqueConsoAppart, valIdealeConsoAppart, description)
INSERT INTO TypeSubstance VALUES (1, 'chaleur', 50000, 5000, 'chaleur...');
INSERT INTO TypeSubstance VALUES (2, 'dioxyde de carbone', 50000, 13000, 'le dioxyde de carbone...');

-- Produire (idTypeAppareil, idTypeSubstance, qteMinParJour, qteMaxParJour, quantiteAllume)
INSERT INTO Produire VALUES (1, 1, 0, 1000, 500); -- chauffage élec, chaleur
INSERT INTO Produire VALUES (2, 1, 0, 500, 100); -- réfrigérateur, chaleur
INSERT INTO Produire VALUES (5, 1, 0, 1000, 500); -- plaques de cuisson, chaleur
INSERT INTO Produire VALUES (7, 1, 0, 1000, 500); -- chauffage au gaz, chaleur
INSERT INTO Produire VALUES (7, 2, 0, 1000, 500); -- chauffage au gaz, dioxyde de carbone

-- HistoriqueConsommation (idConso, dateOn, dateOff, idAppareil)
INSERT INTO HistoriqueConsommation VALUES (1, '2007-03-11', '2013-04-15', 2); -- lampe
INSERT INTO HistoriqueConsommation VALUES (2, '2014-06-01', '2020-06-01', 1); -- chauffage éléctrique
INSERT INTO HistoriqueConsommation VALUES (3, '2015-01-04', '2019-08-19', 4); -- télévision
INSERT INTO HistoriqueConsommation VALUES (4, '2018-05-27', '2021-03-03', 3); -- aspirateur
