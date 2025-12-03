<?php

    $host = 'localhost';
    $utilisateur = 'root';
    $nom_base_donnee = 'zoo';
    $password = '';

    $connection = new mysqli($host,$utilisateur,$password,$nom_base_donnee);

    if ($connection -> connect_error) {
        die('Erreur hors de la connexion sur la base de donnée: '.$connection -> connect_error);
    }


?>