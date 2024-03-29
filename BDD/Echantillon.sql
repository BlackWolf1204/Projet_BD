-- Données fictives
-- Ces données sont nécessaires pour que le site fonctionne (TypeAppartement, TypeAppareil...)

-- Info personne (idPersonne, nom, dateNais, genre, email, tel, prenom)
INSERT INTO InfoPersonne VALUES (1, 'MARTIN', '1990-01-01', 'H', 'gabriel9854@gmail.com', '0695867428', 'Gabriel');
INSERT INTO InfoPersonne VALUES (2, 'ETIENNE', '1997-01-01', 'H', 'Adam7474@gmail.com', '0659852674', 'Adam');
INSERT INTO InfoPersonne VALUES (3, 'MALLET', '1995-01-01', 'F', 'AlaineE9586@gmail.com', '0635982412', 'Alaine');
INSERT INTO InfoPersonne VALUES (4, 'LAURENT', '1999-01-01', 'H', 'Lucas22@gmail.com', '0639356827', 'Lucas');
INSERT INTO InfoPersonne VALUES (5, 'PETIT', '1997-01-01', 'F', 'Doriane562@gmail.com', '0695847233', 'Doriane');
INSERT INTO InfoPersonne VALUES (6, 'DUPONT', '1995-01-01', 'A', 'dpdu2222@gmail.com', '0635987420', 'Dupont');
INSERT INTO InfoPersonne VALUES (7, 'DUPONT', '2003-05-04', 'F', 'mar.dupont@gmail.com', '0258721875', 'Marie');
INSERT INTO InfoPersonne VALUES (8, 'DURAND', '1953-08-17', 'F', 't.durand@gmail.com', '0593241360', 'Thérèse');
INSERT INTO InfoPersonne VALUES (9, 'HUGUET', '1957-03-23', 'H', 'quentin.hug7@gmail.com', '0330623907', 'Quentin');
INSERT INTO InfoPersonne VALUES (10, 'ROUSSEAU', '1974-06-08', 'F', 'roxane-rousseau@gmail.com', '0614421232', 'Roxane');

-- Administrateur (idPersonne, identifiant, mdp, dateCreation)
INSERT INTO Administrateur VALUES (1, 'gabriel9854', 'd269d30513bca41eb810eb899dcbf87b6bf00f8e', '2022-12-16'); -- yRTX7pf6
INSERT INTO Administrateur VALUES (4, 'Lucas22', 'adac4426a544473cd74a61a48f145cdbb38d1f07', '2022-12-16'); -- TgeiRD8v7

-- Utilisateur (idPersonne, login, mdp)
INSERT INTO Utilisateur VALUES (2, 'Adam7474', '92229b4b0d3adbd8fb017a3281b382654dbe0ac1', '2022-12-16'); -- 97Edmf
INSERT INTO Utilisateur VALUES (3, 'Alaine8', 'fe518362407a1723b8e8e14b7c4a7dbb47876ab2', '2022-12-16'); -- Ht5e9d
INSERT INTO Utilisateur VALUES (4, 'Lucas', '63edb57989e8d3168e7c2e5f48dcd0f20b967b07', '2022-12-16'); -- zk2C8mM
INSERT INTO Utilisateur VALUES (5, 'Doriane', '8b0a16c3fb5dc325cc51d2331f3d86bccac487ae', '2022-12-16'); -- rGh9L2m
INSERT INTO Utilisateur VALUES (6, 'dupont1172', '7c854345a38e7750f534c58de55f63621322a893', '2022-12-16'); -- brique
INSERT INTO Utilisateur VALUES (7, 'marie2323', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2022-12-16'); -- 123456
INSERT INTO Utilisateur VALUES (8, 'thérèse7643', 'e731a7b612ab389fcb7f973c452f33df3eb69c99', '2022-12-16'); -- p4ssw0rd

-- Région (codeRegion, nomRegion)
INSERT INTO Region VALUES (24, 'Centre-Val de Loire');
INSERT INTO Region VALUES (11, 'Île-de-France');
INSERT INTO Region VALUES (84, 'Auvergne-Rhône-Alpes');

-- Département (codeDepartement, nomDepartement, codeRegion)
INSERT INTO Departement VALUES (37, 'Indre-et-Loire', 24);
INSERT INTO Departement VALUES (75, 'Paris', 11);
INSERT INTO Departement VALUES (63, 'Puy-de-Dôme', 84);

-- Ville (idVille, nomVille, codePostal, codeDepartement)
INSERT INTO Ville VALUES (1, 'Tours', 37200, 37);
INSERT INTO Ville VALUES (2, 'Paris', 75000, 75);
INSERT INTO Ville VALUES (3, 'Clermont-Ferrand', 63000, 63);

-- Rue (idRue, nomRue, idVille)
INSERT INTO Rue VALUES (1, 'BD de chinon', 1);
INSERT INTO Rue VALUES (2, 'Rue Saint-Lazara', 2);
INSERT INTO Rue VALUES (3, 'Rue du Ressort', 3);

-- Adresse (idAdresse, numeroRue, idRue)
INSERT INTO Adresse VALUES (1, 4, 1);
INSERT INTO Adresse VALUES (2, 16, 2);
INSERT INTO Adresse VALUES (3, 10, 3);
INSERT INTO Adresse VALUES (4, 11, 3);
INSERT INTO Adresse VALUES (5, 12, 3);
INSERT INTO Adresse VALUES (6, 7, 1);


-- Propriété (idPropriete, nomPropriete, degréIsolation, idAdresse)
INSERT INTO Propriete VALUES (1, 'Tranquillité', 'C', 1);
INSERT INTO Propriete VALUES (2, 'Laval', 'B', 2);
INSERT INTO Propriete VALUES (3, 'Résidence du Parc', 'C', 3);
INSERT INTO Propriete VALUES (4, 'Résidence le Clos', 'B', 4);
INSERT INTO Propriete VALUES (5, 'Maison de la Tour', 'A', 5);
INSERT INTO Propriete VALUES (6, 'Hôtel de la Massonnière', 'F', 6);

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
-- Résidence Le Clos : 4 appartements (T2, T4, Duplex et F3)
INSERT INTO Appartement VALUES (5, 1, 1, 3, 4); -- T2
INSERT INTO Appartement VALUES (6, 2, 2, 7, 4); -- T4
INSERT INTO Appartement VALUES (7, 3, 3, 13, 4); -- Duplex
INSERT INTO Appartement VALUES (8, 4, 1, 19, 4); -- F3
-- Maison de la Tour : 1 appartements (T3)
INSERT INTO Appartement VALUES (9, 1, 1, 5, 5); -- T3
-- Hôtel de la Massonnière : 6 appartements (3 T2, 1 T3, 2 T1)
INSERT INTO Appartement VALUES (10, 1, 1, 3, 6); -- T2
INSERT INTO Appartement VALUES (11, 2, 2, 3, 6); -- T2
INSERT INTO Appartement VALUES (12, 3, 3, 3, 6); -- T2
INSERT INTO Appartement VALUES (13, 4, 1, 5, 6); -- T3
INSERT INTO Appartement VALUES (14, 5, 2, 1, 6); -- T1
INSERT INTO Appartement VALUES (15, 6, 3, 1, 6); -- T1

-- Type pièce (typePiece, libéllé)
INSERT INTO TypePiece VALUES (1, 'cuisine');
INSERT INTO TypePiece VALUES (2, 'salon');
INSERT INTO TypePiece VALUES (3, 'salle à manger');
INSERT INTO TypePiece VALUES (4, 'pièce principale');
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
-- Résidence Le Clos : 4 appartements (T2, T4, Duplex et F3)
INSERT INTO Piece VALUES (9, 2, 5); -- salon
INSERT INTO Piece VALUES (10, 1, 5); -- cuisine
INSERT INTO Piece VALUES (11, 3, 6); -- salle à manger
INSERT INTO Piece VALUES (12, 4, 6); -- pièce principale
INSERT INTO Piece VALUES (13, 5, 6); -- chambre
INSERT INTO Piece VALUES (14, 5, 6); -- chambre
INSERT INTO Piece VALUES (15, 4, 7); -- pièce principale
INSERT INTO Piece VALUES (16, 5, 7); -- chambre
INSERT INTO Piece VALUES (17, 5, 8); -- chambre
INSERT INTO Piece VALUES (18, 4, 8); -- pièce principale
INSERT INTO Piece VALUES (19, 5, 8); -- chambre
-- Maison de la Tour : 1 appartements (T3)
INSERT INTO Piece VALUES (20, 2, 9); -- salon
INSERT INTO Piece VALUES (21, 1, 9); -- cuisine
INSERT INTO Piece VALUES (22, 5, 9); -- chambre
-- Hôtel de la Massonnière : 6 appartements (3 T2, 1 T3, 2 T1)
INSERT INTO Piece VALUES (23, 1, 10); -- cuisine
INSERT INTO Piece VALUES (24, 5, 10); -- chambre
INSERT INTO Piece VALUES (25, 1, 11); -- cuisine
INSERT INTO Piece VALUES (26, 5, 11); -- chambre
INSERT INTO Piece VALUES (27, 1, 12); -- cuisine
INSERT INTO Piece VALUES (28, 5, 12); -- chambre
INSERT INTO Piece VALUES (29, 1, 13); -- cuisine
INSERT INTO Piece VALUES (30, 5, 13); -- chambre
INSERT INTO Piece VALUES (31, 5, 13); -- chambre
INSERT INTO Piece VALUES (32, 5, 14); -- chambre
INSERT INTO Piece VALUES (33, 5, 15); -- chambre

-- Propriétaire (idPropriete, datedebutprop, datefinprop, idPersonne)
INSERT INTO Proprietaire VALUES (1, '2017-06-18', NULL, 3);
INSERT INTO Proprietaire VALUES (2, '2019-09-03', NULL, 2);
INSERT INTO Proprietaire VALUES (3, '2021-04-27', NULL, 5);
INSERT INTO Proprietaire VALUES (3, '2019-09-03', '2021-04-27', 2);
-- Résidence Le Clos : un propriétaire de 2018 à 2019, puis un autre de 2019 à 2021
INSERT INTO Proprietaire VALUES (4, '2018-02-15', '2019-07-10', 2);
INSERT INTO Proprietaire VALUES (4, '2019-07-10', '2021-04-27', 5);
-- Maison de la Tour : un propriétaire de 2019 à 2021
INSERT INTO Proprietaire VALUES (5, '2019-09-03', '2021-04-27', 5);
-- Hôtel de la Massonnière : un propriétaire depuis 2023
INSERT INTO Proprietaire VALUES (6, '2023-01-10', NULL, 3);

-- Locataire (idAppartement, datedebutloc, dateFinLoc, idPersonne, nbHabitants)
INSERT INTO Locataire VALUES (1, '2020-08-21', NULL, 5, 2);
INSERT INTO Locataire VALUES (3, '2021-02-14', NULL, 2, 1);
INSERT INTO Locataire VALUES (4, '2020-11-17', NULL, 4, 3);
INSERT INTO Locataire VALUES (4, '2019-01-01', '2019-12-31', 2, 1);
INSERT INTO Locataire VALUES (1, '2018-01-01', '2019-12-31', 2, 1);
-- Résidence Le Clos : appartement 1
INSERT INTO Locataire VALUES (5, '2018-02-15', '2019-07-10', 2, 1);
INSERT INTO Locataire VALUES (5, '2019-07-10', '2021-04-27', 5, 2);
-- Résidence Le Clos : appartement 3
INSERT INTO Locataire VALUES (6, '2021-02-14', '2022-07-14', 2, 1);
INSERT INTO Locataire VALUES (6, '2022-08-20', NULL, 5, 2);
-- Résidence Le Clos : appartement 4
INSERT INTO Locataire VALUES (7, '2019-01-01', '2019-12-31', 2, 1);
INSERT INTO Locataire VALUES (7, '2020-11-17', NULL, 4, 3);
-- Maison de la Tour :
INSERT INTO Locataire VALUES (8, '2019-09-03', '2021-04-27', 5, 2);
-- Hôtel de la Massonnière :
INSERT INTO Locataire VALUES (9, '2023-01-10', NULL, 3, 1);
INSERT INTO Locataire VALUES (10, '2023-01-11', NULL, 4, 1);
INSERT INTO Locataire VALUES (11, '2023-01-15', NULL, 2, 1);

-- TypeAppareil (idTypeAppareil, libTypeAppareil, VideoEconomie)
INSERT INTO TypeAppareil VALUES (1, 'chauffage éléctrique', 'https://youtu.be/xzFdC6Dnh3g');
INSERT INTO TypeAppareil VALUES (2, 'réfrigérateur', 'https://youtu.be/dQw4w9WgXcQ');
INSERT INTO TypeAppareil VALUES (3, 'lampe', NULL);
INSERT INTO TypeAppareil VALUES (4, 'aspirateur', NULL);
INSERT INTO TypeAppareil VALUES (5, 'plaques de cuisson', NULL);
INSERT INTO TypeAppareil VALUES (6, 'télévision', NULL);
INSERT INTO TypeAppareil VALUES (7, 'chauffage au gaz', NULL);

UPDATE TypeAppareil SET VideoEconomie = NULL WHERE idTypeAppareil = 3;
UPDATE TypeAppareil SET VideoEconomie = NULL WHERE idTypeAppareil = 4;
UPDATE TypeAppareil SET VideoEconomie = NULL WHERE idTypeAppareil = 5;
UPDATE TypeAppareil SET VideoEconomie = NULL WHERE idTypeAppareil = 6;
UPDATE TypeAppareil SET VideoEconomie = NULL WHERE idTypeAppareil = 7;


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
INSERT INTO TypeRessource VALUES (1, 'électricité', 5000, 500, 'électricité...'); -- Wh / jour / foyer
INSERT INTO TypeRessource VALUES (2, 'gaz', 7000, 700, 'le gaz...'); -- Wh / jour / foyer
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
-- Soit une baignoire de 135 litres = 135 kg d'eau = 135000/18 = 7500 mol d'eau
-- L'eau de capacité thermique Cp = 75 J/(mol.K) à température ambiante
-- Faire passer cette quantité d'eau de 20 °C à 60 °C nécessite Q = 7500*75*40 = 22500 kJ
-- De façon très approximative, un foyer serait donc capable de produire 5000 kJ de chaleur par jour (chauffage...).
-- Nous allons utiliser 400 kJ pour cet exemple.
INSERT INTO TypeSubstance VALUES (1, 'chaleur', 5000, 400, 'chaleur...');
-- Selon les données de l'Ipsos, un ménage français produit en moyenne 7400 kg de CO2 par an.
-- Soit 20 kg par jour.
INSERT INTO TypeSubstance VALUES (2, 'dioxyde de carbone', 200, 20, 'le dioxyde de carbone...');

-- Produire (idTypeAppareil, idTypeSubstance, qteMinParJour, qteMaxParJour, quantiteAllume)
INSERT INTO Produire VALUES (1, 1, 0, 1000, 500); -- chauffage élec, chaleur
INSERT INTO Produire VALUES (2, 1, 0, 500, 100); -- réfrigérateur, chaleur
INSERT INTO Produire VALUES (5, 1, 0, 1000, 700); -- plaques de cuisson, chaleur
INSERT INTO Produire VALUES (7, 1, 0, 1000, 550); -- chauffage au gaz, chaleur
INSERT INTO Produire VALUES (7, 2, 0, 1000, 300); -- chauffage au gaz, dioxyde de carbone

-- HistoriqueConsommation (idConso, dateOn, dateOff, idAppareil)
-- chauffage électrique 1 allumé de novembre à mars tous les ans depuis 2020 jusqu'à 2022
INSERT INTO HistoriqueConsommation VALUES (1, CAST('2020-11-01' AS DATETIME), CAST('2021-03-31' AS DATETIME), 1); -- chauffage éléctrique
INSERT INTO HistoriqueConsommation VALUES (2, CAST('2021-11-01' AS DATETIME), CAST('2022-03-31' AS DATETIME), 1); -- chauffage éléctrique
INSERT INTO HistoriqueConsommation VALUES (3, CAST('2022-11-01' AS DATETIME), NULL, 1); -- chauffage éléctrique (toujours en fonctionnement)

-- lampe 2 allumée tous les soirs du 10 décembre 2022 au 17 décembre 2022
INSERT INTO HistoriqueConsommation VALUES (4, CAST('2022-12-10 18:00:00' AS DATETIME), CAST('2022-12-10 23:00:00' AS DATETIME), 2); -- lampe
INSERT INTO HistoriqueConsommation VALUES (5, CAST('2022-12-11 18:00:00' AS DATETIME), CAST('2022-12-11 23:00:00' AS DATETIME), 2); -- lampe
INSERT INTO HistoriqueConsommation VALUES (6, CAST('2022-12-12 18:00:00' AS DATETIME), CAST('2022-12-12 23:00:00' AS DATETIME), 2); -- lampe
INSERT INTO HistoriqueConsommation VALUES (7, CAST('2022-12-13 18:00:00' AS DATETIME), CAST('2022-12-13 23:00:00' AS DATETIME), 2); -- lampe
INSERT INTO HistoriqueConsommation VALUES (8, CAST('2022-12-14 18:00:00' AS DATETIME), CAST('2022-12-14 23:00:00' AS DATETIME), 2); -- lampe
INSERT INTO HistoriqueConsommation VALUES (9, CAST('2022-12-15 18:00:00' AS DATETIME), CAST('2022-12-15 23:00:00' AS DATETIME), 2); -- lampe
INSERT INTO HistoriqueConsommation VALUES (10, CAST('2022-12-16 18:00:00' AS DATETIME), CAST('2022-12-16 23:00:00' AS DATETIME), 2); -- lampe

-- aspirateur 3 allumé une fois toutes les deux semaines depuis 2021 pour une durée d'une heure
INSERT INTO HistoriqueConsommation VALUES (11, CAST('2022-01-03 19:00:00' AS DATETIME), CAST('2022-01-03 20:00:00' AS DATETIME), 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (12, CAST('2022-01-17 16:00:00' AS DATETIME), CAST('2022-01-17 17:00:00' AS DATETIME), 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (13, CAST('2022-01-31 10:00:00' AS DATETIME), CAST('2022-01-31 11:00:00' AS DATETIME), 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (14, CAST('2022-02-14 13:00:00' AS DATETIME), CAST('2022-02-14 14:00:00' AS DATETIME), 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (15, CAST('2022-02-28 18:00:00' AS DATETIME), CAST('2022-02-28 19:00:00' AS DATETIME), 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (16, CAST('2022-03-14 21:00:00' AS DATETIME), CAST('2022-03-14 22:00:00' AS DATETIME), 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (17, CAST('2022-03-28 23:00:00' AS DATETIME), CAST('2022-03-29 00:00:00' AS DATETIME), 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (18, CAST('2022-04-11 08:00:00' AS DATETIME), CAST('2022-04-11 09:00:00' AS DATETIME), 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (19, CAST('2022-04-25 11:00:00' AS DATETIME), CAST('2022-04-25 12:00:00' AS DATETIME), 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (20, CAST('2022-05-09 14:00:00' AS DATETIME), CAST('2022-05-09 15:00:00' AS DATETIME), 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (21, CAST('2022-05-23 17:00:00' AS DATETIME), CAST('2022-05-23 18:00:00' AS DATETIME), 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (22, CAST('2022-06-06 20:00:00' AS DATETIME), CAST('2022-06-06 21:00:00' AS DATETIME), 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (23, CAST('2022-06-20 23:00:00' AS DATETIME), CAST('2022-06-21 00:00:00' AS DATETIME), 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (24, CAST('2022-07-05 12:00:00' AS DATETIME), CAST('2022-07-05 13:00:00' AS DATETIME), 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (25, CAST('2022-07-19 05:00:00' AS DATETIME), CAST('2022-07-19 06:00:00' AS DATETIME), 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (26, CAST('2022-08-02 08:00:00' AS DATETIME), CAST('2022-08-02 09:00:00' AS DATETIME), 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (27, CAST('2022-08-16 11:00:00' AS DATETIME), CAST('2022-08-16 12:00:00' AS DATETIME), 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (28, CAST('2022-08-30 14:00:00' AS DATETIME), CAST('2022-08-30 15:00:00' AS DATETIME), 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (29, CAST('2022-09-13 17:00:00' AS DATETIME), CAST('2022-09-13 18:00:00' AS DATETIME), 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (30, CAST('2022-09-27 17:00:00' AS DATETIME), CAST('2022-09-27 18:00:00' AS DATETIME), 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (31, CAST('2022-10-11 17:00:00' AS DATETIME), CAST('2022-10-11 18:00:00' AS DATETIME), 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (32, CAST('2022-10-25 16:00:00' AS DATETIME), CAST('2022-10-25 17:00:00' AS DATETIME), 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (33, CAST('2022-11-08 15:00:00' AS DATETIME), CAST('2022-11-08 16:00:00' AS DATETIME), 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (34, CAST('2022-11-22 14:00:00' AS DATETIME), CAST('2022-11-22 15:00:00' AS DATETIME), 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (35, CAST('2022-12-06 15:00:00' AS DATETIME), CAST('2022-12-06 16:00:00' AS DATETIME), 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (36, CAST('2022-12-20 16:00:00' AS DATETIME), CAST('2022-12-20 17:00:00' AS DATETIME), 3); -- aspirateur
INSERT INTO HistoriqueConsommation VALUES (37, CAST('2023-01-03 17:00:00' AS DATETIME), CAST('2023-01-03 18:00:00' AS DATETIME), 3); -- aspirateur

-- autres appareils :
INSERT INTO HistoriqueConsommation VALUES (38, CAST('2022-01-04' AS DATETIME), CAST('2022-08-19' AS DATETIME), 4); -- télévision
INSERT INTO HistoriqueConsommation VALUES (39, CAST('2022-05-20' AS DATETIME), CAST('2022-07-01' AS DATETIME), 5); -- réfrigérateur
INSERT INTO HistoriqueConsommation VALUES (40, CAST('2022-05-08' AS DATETIME), CAST('2023-01-01' AS DATETIME), 6); -- plaques de cuisson
INSERT INTO HistoriqueConsommation VALUES (41, CAST('2019-08-06' AS DATETIME), NULL, 7); -- chauffage au gaz
INSERT INTO HistoriqueConsommation VALUES (42, CAST('2021-08-02' AS DATETIME), CAST('2022-06-01' AS DATETIME), 8); -- lampe
INSERT INTO HistoriqueConsommation VALUES (43, CAST('2019-08-08' AS DATETIME), CAST('2020-04-01' AS DATETIME), 10); -- lampe
INSERT INTO HistoriqueConsommation VALUES (44, CAST('2021-04-04' AS DATETIME), CAST('2022-11-01' AS DATETIME), 11); -- chauffage au gaz
INSERT INTO HistoriqueConsommation VALUES (45, CAST('2021-09-06' AS DATETIME), CAST('2022-07-01' AS DATETIME), 12); -- lampe
INSERT INTO HistoriqueConsommation VALUES (46, CAST('2019-07-26' AS DATETIME), NULL, 13); -- chauffage au gaz (toujours en cours)
INSERT INTO HistoriqueConsommation VALUES (47, CAST('2019-12-10' AS DATETIME), CAST('2020-01-01' AS DATETIME), 14); -- lampe
INSERT INTO HistoriqueConsommation VALUES (48, CAST('2023-01-06' AS DATETIME), NULL, 14); -- lampe
