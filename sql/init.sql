-- Base de données pour la gestion des horaires

CREATE DATABASE IF NOT EXISTS GestionHoraire CHARACTER SET utf8mb4;
USE GestionHoraire;

DROP TABLE IF EXISTS creneaux;
DROP TABLE IF EXISTS cours;
DROP TABLE IF EXISTS classes;

CREATE TABLE classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL UNIQUE,
    annee_scolaire VARCHAR(9) NOT NULL
);

CREATE TABLE cours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(20) NOT NULL,
    nom VARCHAR(120) NOT NULL
);

CREATE TABLE creneaux (
    id INT AUTO_INCREMENT PRIMARY KEY,
    classe_id INT NOT NULL,
    cours_id INT NOT NULL,
    jour ENUM('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi') NOT NULL,
    heure_debut TIME NOT NULL,
    heure_fin TIME NOT NULL,
    salle VARCHAR(20) NOT NULL,
    FOREIGN KEY (classe_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (cours_id) REFERENCES cours(id) ON DELETE CASCADE
);

-- Données

INSERT INTO classes (nom, annee_scolaire) VALUES
('I.DA-P3A', '2026-2027'),
('I.DA-P1A', '2026-2027');

INSERT INTO cours (code, nom) VALUES
('AWEB3', 'Atelier Web'),
('ARASP', 'Atelier Raspberry Pi'),
('JS', 'JavaScript');

INSERT INTO creneaux (classe_id, cours_id, jour, heure_debut, heure_fin, salle) VALUES
(1, 1, 'jeudi', '08:05', '11:40', 'C205'),
(1, 2, 'lundi', '12:40', '16:10', 'C301'),
(2, 3, 'mardi', '08:05', '11:40', 'R104');
