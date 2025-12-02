/*creation du base de donnée*/
CREATE database zoo;
use zoo;

/*la creation des tables sur la base de donnée*/
CREATE TABLE habitats (
    id int primary key AUTO_INCREMENT,
    nom_habitat varchar(250),
    description_habitat varchar(250)
;)

CREATE TABLE animal (
    id int primary key AUTO_INCREMENT,
    nom varchar(150),
    type_alimentaire varchar(100),
    image_animal varchar(250),
    id_habitat int,
    FOREIGN KEY (id_habitat) REFERENCES habitats(id)
    on delete cascade
    on update cascade
);


/* Insertion d'habitats */
INSERT INTO habitats (nom_habitat, description_habitat) VALUES
('Savane', 'Grande plaine herbeuse avec quelques arbres'),
('Jungle', 'Forêt tropicale dense et humide'),
('Océan', 'Milieu marin avec de leau salée'),
('Désert', 'Terre aride et sèche avec peu de végétation');

/* Insertion d'animaux */
INSERT INTO animal (nom, type_alimentaire, image_animal, id_habitat) VALUES
('Lion', 'Carnivore', 'lion.jpg', 1),
('Éléphant', 'Herbivore', 'elephant.jpg', 1),
('Singe', 'Omnivore', 'singe.jpg', 2),
('Tigre', 'Carnivore', 'tigre.jpg', 2),
('Dauphin', 'Carnivore', 'dauphin.jpg', 3),
('Chameau', 'Herbivore', 'chameau.jpg', 4);


/*Modification*/
update animal set nom = 'lion1'where id = 1 ;
update habitats set nom_habitat = 'Jungle1'where id = 1 ;

/*Suppression d'un animal : */
delete from animal where id = 1;
delete from animal where type_alimentaire = 'Carnivore';


/*Affichage des animaux du zoo*/
/*Affichage de tout les animaux*/
select * from animal;

/*Filtrage par type alimentaire */
select * from animal where type_alimentaire = 'Carnivore';
/*Filtrage par Habitat*/
select nom,nom_habitat from animal,habitats where animal.id_habitat = habitats.id and nom_habitat='Désert';