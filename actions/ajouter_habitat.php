<?php
require_once __DIR__ . '/../config/connexion.php';

if (isset($_POST['ajouter_habitat'])) {

    $nom = $_POST['nom_habitat'];
    $description = $_POST['description_habitat'];

    if (!empty($nom) && !empty($description)) {

        $sql = "INSERT INTO habitats (nom_habitat, description_habitat)
                VALUES (?, ?)";

        $stmt = $connexion->prepare($sql);
        $stmt->bind_param("ss", $nom, $description);

        if ($stmt->execute()) {
            header("Location: ../index.php");
            exit();
        }
    }
}
?>
