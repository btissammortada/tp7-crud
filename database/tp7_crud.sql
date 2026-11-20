
CREATE DATABASE IF NOT EXISTS tp7_crud;
USE tp7_crud;

CREATE TABLE IF NOT EXISTS formations (
    id_formation INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    duree INT,
    niveau VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS etudiants (
    id_etudiant INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE,
    date_inscription DATE,
    id_formation INT,
    FOREIGN KEY (id_formation)
        REFERENCES formations(id_formation)
);

CREATE TABLE IF NOT EXISTS modules (
    id_module INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    volume_horaire INT,
    coefficient DECIMAL(4,2),
    id_formation INT,
    FOREIGN KEY (id_formation)
        REFERENCES formations(id_formation)
);
