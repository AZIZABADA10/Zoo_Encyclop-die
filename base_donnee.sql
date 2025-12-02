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