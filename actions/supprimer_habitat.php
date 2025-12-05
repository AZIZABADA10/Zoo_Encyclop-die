<?php
require_once __DIR__ . '/../config/connexion.php';

if (isset($_GET['supprimer'])) {
    $id = intval($_GET['supprimer']);

    // Verifier si des animaux utilisent cet habitat
    $check = $connexion->query("SELECT COUNT(*) AS total FROM animal WHERE id_habitat = $id");
    $row = $check->fetch_assoc();

    if ($row['total'] > 0) {
        header("Location: ../index.php?error=habitat_utilisé");
        exit();
    }

    $sql = "DELETE FROM habitats WHERE id = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: ../index.php");
    exit();
}
