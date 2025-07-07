CREATE DATABASE banque CHARACTER SET utf8mb4;;

USE banque;

CREATE TABLE etablissement(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    nom_etablissement VARCHAR(100)
);

CREATE TABLE financement(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    valeur DECIMAL(15, 2) NOT NULL,
    id_etablissement INTEGER,
    descri TEXT,
    date_financement DATE NOT NULL,
    FOREIGN KEY (id_etablissement) REFERENCES etablissement(id)
);

CREATE TABLE client(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    date_naissance DATE,
    date_inscription DATE DEFAULT CURRENT_DATE
);

CREATE TABLE revenu(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    montant DECIMAL(15, 2) NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE,
    id_client INTEGER NOT NULL,
    FOREIGN KEY (id_client) REFERENCES client(id)
);

CREATE TABLE compte(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    id_client INTEGER NOT NULL,
    date_creation DATE NOT NULL DEFAULT CURRENT_DATE,
    FOREIGN KEY (id_client) REFERENCES client(id)
);

CREATE TABLE historique_compte(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    id_compte INTEGER,
    descri TEXT,
    montant DECIMAL(15,2) NOT NULL,
    date_action DATE,
    FOREIGN KEY (id_compte) REFERENCES compte(id)
);

CREATE TABLE type_pret(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    designation VARCHAR(100) NOT NULL,
    taux_interet DECIMAL(5, 2) NOT NULL CHECK (taux_interet >= 0),
    montant_min DECIMAL(15, 2) NOT NULL CHECK (montant_min > 0),
    montant_max DECIMAL(15, 2) NOT NULL CHECK (montant_max > montant_min),
    duree_min INT NOT NULL CHECK (duree_min >= 0), -- en mois
    duree_max INT NOT NULL CHECK (duree_max >= duree_min),
    interet_retard DECIMAL(5, 2) NOT NULL CHECK (interet_retard < taux_interet)
);

CREATE TABLE type_remboursement(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    designation VARCHAR(100) NOT NULL   -- avec amortissement, sans amortissement
);

CREATE TABLE pret(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    id_type INTEGER NOT NULL,
    id_type_remboursement INTEGER NOT NULL,
    frequence INT NOT NULL, 
    duree INT NOT NULL,     
    id_compte INTEGER,
    date_pret DATE NOT NULL DEFAULT CURRENT_DATE,
    montant DECIMAL(15,2),
    FOREIGN KEY (id_type) REFERENCES type_pret(id),
    FOREIGN KEY (id_type_remboursement) REFERENCES type_remboursement(id),
    FOREIGN KEY (id_compte) REFERENCES compte (id)
);

CREATE TABLE statut(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    designation VARCHAR(50)
);

CREATE TABLE statut_pret(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    id_pret INTEGER NOT NULL,
    id_statut INTEGER NOT NULL,
    date_debut DATE NOT NULL DEFAULT CURRENT_DATE,
    FOREIGN KEY (id_pret) REFERENCES pret(id),
    FOREIGN KEY (id_statut) REFERENCES statut(id)
);

CREATE TABLE payement(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    id_pret INTEGER NOT NULL,
    date_payement DATE NOT NULL DEFAULT CURRENT_DATE,
    montant DECIMAL(15, 2) NOT NULL,
    FOREIGN KEY (id_pret) REFERENCES pret(id)
);

CREATE TABLE historique_banque(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    id_etablissement INTEGER,
    montant DECIMAL(15,2) NOT NULL,
    date_action DATE NOT NULL DEFAULT CURRENT_DATE,
    descri TEXT,
    FOREIGN KEY (id_etablissement) REFERENCES etablissement(id)
);


