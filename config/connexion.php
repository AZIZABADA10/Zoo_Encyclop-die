<?php

    $host = 'localhost';
    $utilisateur = 'root';
    $nom_base_donnee = 'zoo';
    $password = '';

    $connexion = new mysqli($host,$utilisateur,$password,$nom_base_donnee);

    if ($connexion -> connect_error) {
        die('Erreur hors de la connexion sur la base de donnée: '.$connection -> connect_error);
    }


?>