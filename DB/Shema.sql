CREATE DATABASE mabagnole_v2;
use mabagnole_v2;

create table utilisateur (
    id_utilisateur INT PRIMARY KEY AUTO_INCREMENT,
    nom varchar(50),
    email varchar(200) unique,
    mot_de_passe varchar(256),
    `role` enum('admin', 'client') default 'client'
);

create table categorie (
    id_categorie int PRIMARY key AUTO_INCREMENT,
    titre varchar(50),
    `description` text
);

create table vehicule (
    id_vehicule INT PRIMARY KEY AUTO_INCREMENT,
    modele varchar(40),
    marque varchar(40),
    prix_par_jour decimal(10,2) unsigned,
    disponible boolean default 1,
    `image` varchar(256),
    id_categorie int,
    foreign key (id_categorie) references categorie(id_categorie)
);


CREATE TABLE reservation (
    id_utilisateur INT,
    id_vehicule INT,
    date_debut DATE,
    date_fin DATE,
    statut_reservation ENUM('en_attente', 'confirmee', 'annulee') DEFAULT 'en_attente',
    PRIMARY KEY (id_utilisateur, id_vehicule),
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur),
    FOREIGN KEY (id_vehicule) REFERENCES vehicule(id_vehicule)
);


create table avis (
    id_utilisateur INT,
    id_vehicule INT,
    commentaire text,
    date_avis date,
    PRIMARY KEY (id_utilisateur,id_vehicule),
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur),
    FOREIGN KEY (id_vehicule) REFERENCES vehicule(id_vehicule)
);


ALTER TABLE avis
ADD COLUMN deleted_at DATETIME DEFAULT NULL;

/* vue sur la base de donnée pour lister les vehicule*/
CREATE VIEW ListeVehicules AS
SELECT 
    v.id_vehicule,v.modele,v.marque,v.prix_par_jour,v.disponible,c.titre AS categorie,
    COUNT(a.id_vehicule) AS nb_avis
FROM vehicule v
JOIN categorie c ON v.id_categorie = c.id_categorie
LEFT JOIN avis a ON v.id_vehicule = a.id_vehicule
GROUP BY v.id_vehicule;

/*procédure stoke*/
DELIMITER $$

create PROCEDURE AjouterReservation(
    IN p_id_utilisateur INT,
    IN p_id_vehicule INT,
    IN p_date_debut DATE,
    IN p_date_fin DATE
)
begin 
    INSERT INTO reservation (id_utilisateur, id_vehicule, date_debut, date_fin, statut_reservation)
    VALUES (p_id_utilisateur, p_id_vehicule, p_date_debut, p_date_fin, 'en_attente');
end $$

DELIMITER ;

/* les neveau table */
create table Theme (
    id_theme int PRIMARY key AUTO_INCREMENT,
    titre varchar(50) not NULL,
    description varchar(50)
);

CREATE table Article (
    id_article int AUTO_INCREMENT PRIMARY key,
    titre varchar(90) not null,
    contenu text not null,
    statut_article boolean,
    id_theme int,
    foreign key (id_theme) references Theme(id_theme)
    id_utilisateur int,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur)
);

create table Tag (
    id_tag int AUTO_INCREMENT PRIMARY key,
    tag varchar(50) not null
);

create table tagArticle(
    id_tagArticle int AUTO_INCREMENT PRIMARY key,
    id_tag int,
    id_article int,
    foreign key (id_tag) references Tag(id_tag),
    foreign key (id_article) references Article(id_article)
);

create table favorite(
    id_favorite int AUTO_INCREMENT primary key,
    id_article int,
    id_utilisateur int,
    foreign key (id_article) references Article(id_article),
    foreign key (id_utilisateur) references utilisateur(id_utilisateur)
);


CREATE TABLE commentaire (
    id_commentaire INT AUTO_INCREMENT PRIMARY KEY,
    commentaire TEXT NOT NULL,
    date_commentaire DATETIME DEFAULT CURRENT_TIMESTAMP,
    est_supprime BOOLEAN DEFAULT 0,
    id_article INT NOT NULL,
    FOREIGN KEY (id_article) REFERENCES article(id_article),
    id_utilisateur INT NOT NULL,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur)
);
