DROP DATABASE IF EXISTS banque_simple;
CREATE DATABASE banque_simple CHARACTER SET utf8mb4;
USE banque_simple;

CREATE TABLE etablissement_financier(
    id_etablissement INT AUTO_INCREMENT PRIMARY KEY,
    nom_etablissement VARCHAR(100),
    fond_total DECIMAL(15, 2) NOT NULL
);

CREATE TABLE type_pret(
    id_type_pret INT AUTO_INCREMENT PRIMARY KEY,
    nom_type_pret VARCHAR(100),
    taux_interet DECIMAL(5, 2) NOT NULL
);

CREATE TABLE client(
    id_client INT AUTO_INCREMENT PRIMARY KEY,
    nom_client VARCHAR(100),
    date_naissance DATE
); 

CREATE TABLE pret(
    id_pret INT AUTO_INCREMENT PRIMARY KEY,
    id_client INT,
    id_etablissement INT,
    id_type_pret INT,
    montant DECIMAL(15, 2) NOT NULL,
    date_pret DATE,
    duree INT NOT NULL, -- mois
    FOREIGN KEY (id_client) REFERENCES client(id_client),
    FOREIGN KEY (id_etablissement) REFERENCES etablissement_financier(id_etablissement),
    FOREIGN KEY (id_type_pret) REFERENCES type_pret(id_type_pret)
);



