<?php
require_once __DIR__. '/../config/connexion.php';

$total_animaux = $connexion -> query("select count(*) as total from animal;");
$res = $total_animaux -> fetch_assoc();

$total_animaux_carnivores = $connexion -> query(
    "SELECT COUNT(*) as total_animaux_carnivors FROM animal 
     GROUP BY type_alimentaire 
     HAVING type_alimentaire = 'carnivore';");
$res_carnivors = $total_animaux_carnivores -> fetch_assoc();

/** total des Herbivores */
$total_animaux_herbivores = $connexion -> query(
    "SELECT count(*) as total_animaux_herbivores 
     from animal 
     group by type_alimentaire 
     having  type_alimentaire = 'herbivore';
");
$res_herbivors = $total_animaux_herbivores -> fetch_assoc();


/** Total animaux Omnivores */
$total_animaux_omnivores = $connexion -> query(
    "SELECT count(*) as total_animaux_omnivores 
    from animal 
    group by type_alimentaire
    having type_alimentaire = 'omnivore'
    "
);

$res_omnivores = $total_animaux_omnivores -> fetch_assoc();


?>