

CREATE TABLE cours (
    id_cours INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    categorie VARCHAR(100),
    date_cours DATE NOT NULL,
    heure TIME NOT NULL,
    duree INT NOT NULL,             
    nb_max_participants INT NOT NULL
);


CREATE TABLE equipements (
    id_equipement INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    type VARCHAR(100),
    quantite_disponible INT NOT NULL,
    etat ENUM('bon', 'moyen', 'à remplacer') NOT NULL
);


CREATE TABLE cours_equipements (
    id_cours INT NOT NULL,
    id_equipement INT NOT NULL,
    quantite_necessaire INT NOT NULL, 

    PRIMARY KEY (id_cours, id_equipement),

    FOREIGN KEY (id_cours) REFERENCES cours(id_cours),
    FOREIGN KEY (id_equipement) REFERENCES equipements(id_equipement)
);


CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nomcomplet VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);


INSERT INTO cours (nom, categorie, date_cours, heure, duree, nb_max_participants) VALUES
('Yoga Matinal', 'Fitness', '2025-01-15', '08:00:00', 60, 15),
('Séance de Cardio Intense', 'Fitness', '2025-01-15', '18:30:00', 45, 20),
('Initiation à la Poterie', 'Loisirs', '2025-01-16', '14:00:00', 120, 8),
('Cours de Natation', 'Sport', '2025-01-16', '10:00:00', 90, 12);

-- Insérer les données dans la table `equipements`
INSERT INTO equipements (nom, type, quantite_disponible, etat) VALUES
('Tapis de Yoga', 'Tapis', 30, 'bon'),
('Haltères 2kg', 'Poids', 50, 'bon'),
('Roues de potier', 'Outil', 10, 'bon'),
('Planche de natation', 'Accessoire', 25, 'moyen'),
('Chaise', 'Mobilier', 100, 'bon');

-- Insérer les données dans la table `cours_equipements`
INSERT INTO cours_equipements (id_cours, id_equipement, quantite_necessaire) VALUES
(1, 1, 15),
(2, 2, 40),
(3, 3, 10);
