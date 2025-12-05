<?php

require_once __DIR__ . '/../config/connexion.php';

if (isset($_GET['supprimer'])) {
    $id = $_GET['supprimer'];
    $requet_sup = "DELETE FROM animal where id ='$id'";
    $connexion -> query($requet_sup);
    header("Location: ../index.php");
    exit();
}



?>