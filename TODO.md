# 1. Projet : Utilisation d’une base de donnees ´ a travers un site web dynamique (HTML-CSS-PHP-MySQL)

## 1.1 Pré-requis

- [x] MySQL
- [x] HTML5 - CSS3
- [x] PHP
- [x] IDE libre
- [x] Pas de framework, librairie pour les graphiques des statistiques
- [ ] git, ajouter le prof

## 1.2 But du projet

- [x] application web : BDD, livraison du site web, implémentation de la BDD
- [x] BDD à partir des règles de gestion
- [x] Mettre en pratique les notions de HTML, PHP, CSS, BDD...
- [x] Communication BDD / appli WEB
- [x] Conception d'une appli web avec BDD

## 1.3 Énnoncé

Vous (votre équipe) êtes une société de fournitures de services informatiques notamment la conception et création d’applications web responsive sur mesure.
Votre client, la société anonyme nommée Contrôle de Qualité de Citoyenneté (CQC SA) vous soumets son projet.
Son rôle est d’encourager les citoyens français à une consommation modérée et économe des ressources naturelles.
Pour cela, CQC SA décide dans un premier temps de mettre en place une application web responsive qui permettra de suivre la consommation des citoyens en diverses ressources (Ex: Electricité, gaz, eau,...etc) et l’émission de substances nocives pour l’environnement
(Ex: CO2).

- [ ] encourager les citoyens à une consommation éco
- [ ] app **responsive**
- [ ] Suivre la conso (électricité, gaz, eau, ...)
- [ ] Suivre l'émission de substances (CO2)

### 1.3.1 Spécifications foncitonnelles

- [x] Inscription - connexion - déconnexion
- [ ] Gestion des profils
  - [ ] Admin : stats de toutes les maisons
  - [ ] Utilisateur : voir sa propre consommation et l'évolution de son statut
- [ ] Gestion des maisons :
  - [x] Créer des maisons
  - [x] Ajouter des appartements
  - [x] Ajouter des appareils
  - [ ] Renseigner les locataires (par le propriétaire)
- [ ] Gestion des équipements de la maison :
  - [ ] Allumer / éteindre
  - [ ] Infos consommation et émission en substance
- [ ] Gestion des ressources consommables et des substances
- [ ] Stats Administateur :
  - [x] Histogramme hommes / femmes / autres
  - [ ] Nombre d'abonnés par tranches d'âge : [18;24], ]24;45], ]45;65], 65+
  - [ ] Maison la plus gourmande pour chaque ressource pour un mois donné
		Tenir compte du nombre d'habitants
		Ex :
			maison A => 23 kWh/jour, 1 personne
			maison B => 23 kWh/jour, 2 personnes
			=> maison B plus économe que A
  - [ ] La maison la plus polluante pour chaque substance pour un mois donné
		Tenir compte du nombre d'habitants
  - [ ] Conspmmation / émission mensuelle de chaque maison pour le mois pour chaque ressource / substance
  - [ ] La ville dont les citoyens sont les plus éco-responsables
  - [x] ...


### 1.3.2 Règles de gestion

- [x] Chaque entité a un identifiant auto incrémenté



#### Gestion d'une maison

1. [x] Deux types d'utilisateurs : user et admin
2. [x] Utilisateur peut consulter / modifier son profil
3. [ ] Utilisateur :
   1. [x] personne physique
   2. [x] date création du compte
   3. [ ] état du compte (actif / inactif)
   4. [ ] date de dernière connexion ?
4. [ ] Identifiant unique généré pour chaque utilisateur
   1. [ ] Se connecter avec cet identifant
   2. [ ] Se connecter avec le mail
5. [ ] Âge minimum : 18 ans
6. [x] Personne physique : Nom, prénom, date de naissance, genre, mail, identifiant, numéro de tel
7. [x] Adresse : numéro de maison, nom de rue, code postal, ville
8. [ ] Degré de citoyenneté d'une maison / appartements
9.  [x] Ville => département
10. [x] Département => région
11. [x] Maison = immeuble avec au moins 1 appartement
12. [x] Appartement : différents locataires dans le temps (date début et fin)
13. [x] Propriétaire  : plusieurs maisons, date début et fin
14. [x] Locataire : plusieurs appartements dans la même période
15. [x] Appartement loué à un seul utilisateur dans la même période
16. [x] Appartement : plusieurs habitants dans le contrat location
17. [x] Appartement : type (T1, T2, ...), degré de sécurité (fort, moyen, faible)
18. [x] Pas besion des infos des habitants (uniquement le locataire)
19. [x] Maison : adresse fixe et **unique**, degré d'isolation, nom, évaluation éco-immeuble
20. [x] Type d'appartement par libellé et types de pièces qu'il doit contenir
21. [x] Type de pièce libellé
22. [x] Pièce : décrite par un libellé et type de pièce
23. [x] Appartement peut ne pas avoir toutes les pièces prévues pour son type (donc règle 20 invalidée ?), il peut en avoir plus que prévu

#### Gestion de la consommation des équipements d'un appartement

1. [x] Appartement : plusieurs appareils
2. [x] Appartement : plusieurs exemplaires d'un même appareil
3. [x] Appareil : emplacement précis (description du lieu, **max 30 caractères**, passé à 200 car pas suffisant)
4. [x] Appareil : type d'appareil
5. [x] Type appareil : conso au moins une ressource, émettre 0+ substances nocives
6. [x] Appareil : libellé, description, Type appareil : conso/émission prédéfinie par heure
7. [x] Historique de fonctionnement
   1. [ ] Interrupteur ON/OFF pour les appareils
   2. [ ] Confirer 1s = 1h de consommation / émission
8. [ ] Appareil : mis en marche plusieurs fois dans la même journée
9. [ ] Vidéos de démonstrations pour être économe, chaque appareil a une vidéo

#### Gestion des ressources / substances

1. [x] Ressource / substance : val min / max par jour de conso / production
2. [x] Ressource / substance :
   1. [x] libellé, description
   2. [x] val min / max par jour de consommation / production
   3. [x] val critique de consommation / production par jour
   4. [x] val idéale de consommation / production par jour

### 1.3.3 À faire

1. [x] Le MCD et le MLR de la BD en 3FN
2. [x] La BDD
3. [x] Le script SQL
4. [x] Menu pour naviguer dans les pages du site
5. [ ] Tableau de bord pour l'évolution journalière des valeurs pour les différentes ressources
6. [x] Page pour l'inscription / connexion, page pour consulter / modifier son profil, pour se déconnecter
7. [ ] CRUD (Create-Read-Update-Delete) des entités sélectionnées
8. [ ] CRUD / page de gestion des associations concernées
9. [ ] Trigger pour suppression d'une personne physique
10. [ ] Fin du projet : fichier zippé contenant
    1.  [ ] Compte rendu
    2.  [ ] .lo vu MCD
    3.  [ ] export BDD SGBDR, script SQL...
    4.  [ ] code source du projet

### 1.3.4 Fourni

1. [ ] Projet contenant les pages pour le CRUD (non connecté à la BDD) (????)
2. [ ] Liens vers des vidéos Youtube pour être un citoyen économe (?????)