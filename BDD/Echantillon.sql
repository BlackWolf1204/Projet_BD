-- Données fictives

-- Info personne (idPersonne, nom, dateNaissance, genre, email, tel, prenom)
INSERT INTO InfoPersonne VALUES (1, 'MARTIN', '1990-01-01', 'M', 'gabriel9854@gmail.com', '0695867428', 'Gabriel');
INSERT INTO InfoPersonne VALUES (2, 'ETIENNE', '1997-01-01', 'M', 'Adam7474@gmail.com', '0659852674', 'Adam');
INSERT INTO InfoPersonne VALUES (3, 'MALLET', '1995-01-01', 'F', 'AlaineE9586@gmail.com', '06359824', 'Alaine');
INSERT INTO InfoPersonne VALUES (4, 'LAURENT', '1999-01-01', 'M', 'Lucas22@gmail.com', '0639356827', 'Lucas');
INSERT INTO InfoPersonne VALUES (5, 'PETIT', '1997-01-01', 'F', 'Doriane562@gmail.com', '0695847233', 'Doriane');

-- Administrateur (idPersonne, identifiant, mdp)
INSERT INTO Administrateur VALUES (1, 'gabriel9854@gmail.com', 'd269d30513bca41eb810eb899dcbf87b6bf00f8e'); -- yRTX7pf6
INSERT INTO Administrateur VALUES (4, 'Lucas22@gmail.com', 'adac4426a544473cd74a61a48f145cdbb38d1f07'); -- TgeiRD8v7

-- Utilisateur (idPersonne, login, mdp)
INSERT INTO Utilisateur VALUES (2, 'Adam7474', '92229b4b0d3adbd8fb017a3281b382654dbe0ac1'); -- 97Edmf
INSERT INTO Utilisateur VALUES (3, 'Alaine8', 'fe518362407a1723b8e8e14b7c4a7dbb47876ab2'); -- Ht5e9d
INSERT INTO Utilisateur VALUES (4, 'Lucas', '63edb57989e8d3168e7c2e5f48dcd0f20b967b07'); -- zk2C8mM
INSERT INTO Utilisateur VALUES (5, 'Doriane', '8b0a16c3fb5dc325cc51d2331f3d86bccac487ae'); -- rGh9L2m

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
INSERT INTO Appartement VALUES (1, 2, 1, 3, 3); -- T2
INSERT INTO Appartement VALUES (2, 7, 2, 1, 1); -- T1
INSERT INTO Appartement VALUES (3, 9, 3, 2, 2); -- T1 bis
INSERT INTO Appartement VALUES (4, 10, 2, 2, 2); -- T1 bis

-- Type pièce (typePiece, libéllé)
INSERT INTO TypePiece VALUES (1, 'cuisine');
INSERT INTO TypePiece VALUES (2, 'salon');
INSERT INTO TypePiece VALUES (3, 'salle à manger');
INSERT INTO TypePiece VALUES (4, 'piece principale');
INSERT INTO TypePiece VALUES (5, 'chambre');

-- Pièce (idPiece, typePiece, idAppartement)
INSERT INTO Piece VALUES (1, 2, 1); -- salon
INSERT INTO Piece VALUES (2, 1, 1); -- cuisine
INSERT INTO Piece VALUES (3, 3, 1); -- salle à manger
INSERT INTO Piece VALUES (4, 4, 2); -- pièce principale
INSERT INTO Piece VALUES (5, 5, 3); -- chambre
INSERT INTO Piece VALUES (6, 4, 3); -- pièce principale
INSERT INTO Piece VALUES (7, 5, 4); -- chambre
INSERT INTO Piece VALUES (8, 4, 4); -- pièce principale

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
INSERT INTO Appareil VALUES (2, "La lampe du séjour", "Au milieu du plafond", 3, 3); -- lampe, salle à manger
INSERT INTO Appareil VALUES (3, "L'aspirateur", "Sous les mantaux", 4, 3); -- aspirateur, salle à manger
INSERT INTO Appareil VALUES (4, "La télé", "Devant le canapé", 6, 1); -- télévision, salon
INSERT INTO Appareil VALUES (5, "Le réfrigérateur", "Au fond de la cuisine", 2, 2); -- réfrigérateur, cuisine
INSERT INTO Appareil VALUES (6, "Les plaques de cuisson", "Au dessus de la table", 5, 2); -- plaques de cuisson, cuisine
INSERT INTO Appareil VALUES (7, "Le chauffage du salon", "Au dessus du canapé", 7, 1); -- chauffage au gaz, salon
INSERT INTO Appareil VALUES (8, "La lampe de la chambre", "Au dessus du lit", 3, 5); -- lampe, chambre
INSERT INTO Appareil VALUES (10, "La lampe de la pièce principale", "Au dessus du lit", 3, 6); -- lampe, pièce principale
INSERT INTO Appareil VALUES (11, "Le chauffage de la pièce principale", "Au dessus du lit", 7, 6); -- chauffage au gaz, pièce principale
INSERT INTO Appareil VALUES (12, "La lampe de la chambre", "Au dessus du lit", 3, 7); -- lampe, chambre
INSERT INTO Appareil VALUES (13, "Le chauffage de la chambre", "Au dessus du lit", 7, 7); -- chauffage au gaz, chambre
INSERT INTO Appareil VALUES (14, "La lampe de la pièce principale", "Au dessus du lit", 3, 8); -- lampe, pièce principale

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
-- chauffage électrique 1 allumé de novembre à mars tous les ans depuis 2020 jusqu'à 2022
INSERT INTO HistoriqueConsommation VALUES (0, '2020-11-01', '2021-03-31', 1); -- chauffage éléctrique
INSERT INTO HistoriqueConsommation VALUES (0, '2021-11-01', '2022-03-31', 1); -- chauffage éléctrique
INSERT INTO HistoriqueConsommation VALUES (0, '2022-11-01', '2022-12-31', 1); -- chauffage éléctrique

-- lampe 2 allumée tous les soirs du 10 décembre 2022 au 17 décembre 2022
INSERT INTO HistoriqueConsommation VALUES (0, '2022-12-10 18:00:00', '2022-12-11 23:00:00', 2); -- lampe
INSERT INTO HistoriqueConsommation VALUES (0, '2022-12-11 18:00:00', '2022-12-12 23:00:00', 2); -- lampe
INSERT INTO HistoriqueConsommation VALUES (0, '2022-12-12 18:00:00', '2022-12-13 23:00:00', 2); -- lampe
INSERT INTO HistoriqueConsommation VALUES (0, '2022-12-13 18:00:00', '2022-12-14 23:00:00', 2); -- lampe
INSERT INTO HistoriqueConsommation VALUES (0, '2022-12-14 18:00:00', '2022-12-15 23:00:00', 2); -- lampe
INSERT INTO HistoriqueConsommation VALUES (0, '2022-12-15 18:00:00', '2022-12-16 23:00:00', 2); -- lampe
INSERT INTO HistoriqueConsommation VALUES (0, '2022-12-16 18:00:00', '2022-12-17 23:00:00', 2); -- lampe

-- aspirateur 3 allumé une fois toutes les deux semaines depuis 2021 pour une durée d'une heure
INSERT INTO HistoriqueConsommation VALUES (0, '2022-01-03 19:00:00', '2022-01-03 20:00:00', 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (0, '2022-01-17 16:00:00', '2022-01-17 17:00:00', 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (0, '2022-01-31 10:00:00', '2022-01-31 11:00:00', 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (0, '2022-02-14 13:00:00', '2022-02-14 14:00:00', 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (0, '2022-02-28 18:00:00', '2022-02-28 19:00:00', 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (0, '2022-03-14 21:00:00', '2022-03-14 22:00:00', 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (0, '2022-03-28 23:00:00', '2022-03-29 00:00:00', 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (0, '2022-04-11 08:00:00', '2022-04-11 09:00:00', 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (0, '2022-04-25 11:00:00', '2022-04-25 12:00:00', 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (0, '2022-05-09 14:00:00', '2022-05-09 15:00:00', 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (0, '2022-05-23 17:00:00', '2022-05-23 18:00:00', 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (0, '2022-06-06 20:00:00', '2022-06-06 21:00:00', 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (0, '2022-06-20 23:00:00', '2022-06-21 00:00:00', 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (0, '2022-07-05 12:00:00', '2022-07-05 13:00:00', 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (0, '2022-07-19 05:00:00', '2022-07-19 06:00:00', 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (0, '2022-08-02 08:00:00', '2022-08-02 09:00:00', 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (0, '2022-08-16 11:00:00', '2022-08-16 12:00:00', 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (0, '2022-08-30 14:00:00', '2022-08-30 15:00:00', 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (0, '2022-09-13 17:00:00', '2022-09-13 18:00:00', 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (0, '2022-09-27 17:00:00', '2022-09-27 18:00:00', 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (0, '2022-10-11 17:00:00', '2022-10-11 18:00:00', 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (0, '2022-10-25 16:00:00', '2022-10-25 17:00:00', 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (0, '2022-11-08 15:00:00', '2022-11-08 16:00:00', 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (0, '2022-11-22 14:00:00', '2022-11-22 15:00:00', 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (0, '2022-12-06 15:00:00', '2022-12-06 16:00:00', 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (0, '2022-12-20 16:00:00', '2022-12-20 17:00:00', 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (0, '2023-01-03 17:00:00', '2023-01-03 18:00:00', 3); -- aspirateur

-- autres appareils :
INSERT INTO HistoriqueConsommation VALUES (3, '2015-01-04', '2019-08-19', 4); -- télévision
INSERT INTO HistoriqueConsommation VALUES (3, '2019-10-20', '2020-01-01', 5); -- réfrigérateur
INSERT INTO HistoriqueConsommation VALUES (3, '2019-10-20', '2020-01-01', 6); -- plaques de cuisson
INSERT INTO HistoriqueConsommation VALUES (3, '2019-10-20', '2020-01-01', 7); -- chauffage au gaz
INSERT INTO HistoriqueConsommation VALUES (3, '2019-10-20', '2020-01-01', 8); -- lampe
INSERT INTO HistoriqueConsommation VALUES (3, '2019-10-20', '2020-01-01', 10); -- lampe
INSERT INTO HistoriqueConsommation VALUES (3, '2019-10-20', '2020-01-01', 11); -- chauffage au gaz
INSERT INTO HistoriqueConsommation VALUES (3, '2019-10-20', '2020-01-01', 12); -- lampe
INSERT INTO HistoriqueConsommation VALUES (3, '2019-10-20', '2020-01-01', 13); -- chauffage au gaz
INSERT INTO HistoriqueConsommation VALUES (3, '2019-10-20', '2020-01-01', 14); -- lampe
