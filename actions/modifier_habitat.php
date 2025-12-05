<?php
require_once __DIR__ . '/../config/connexion.php';

$id = $_GET['id'] ?? null;

// Récupération des informations
if ($id) {
    $stmt = $connexion->prepare("SELECT * FROM habitats WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $habitat = $stmt->get_result()->fetch_assoc();
}

if (isset($_POST['modifier_habitat'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom_habitat'];
    $description = $_POST['description_habitat'];

    $sql = "UPDATE habitats SET nom_habitat=?, description_habitat=? WHERE id=?";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("ssi", $nom, $description, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Habitat modifié avec succès !'); window.location.href='../index.php';</script>";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Habitat</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../assets/style/styles.css">
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Header identique à Modifier Animal -->
    <header class="bg-purple-500 text-white shadow-md">
        <div class="container mx-auto px-6 py-6 flex items-center justify-between">
            <h1 class="text-3xl font-bold flex items-center">
                <i class="fas fa-tree text-4xl md:text-5xl float-animation mr-3"></i>
                Gestion des Habitats
            </h1>

            <a href="../index.php" 
               class="bg-white text-purple-500 px-4 py-2 rounded-xl font-semibold hover:bg-purple-100 transition">
                Retour
            </a>
        </div>
    </header>

    <!-- Contenu principal -->
    <main class="flex-1 container mx-auto px-6 py-10">
        <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-3xl mx-auto">

            <h2 class="text-3xl font-bold text-gray-800 mb-8 flex items-center">
                <i class="fas fa-edit text-purple-500 mr-3"></i>
                Modifier un Habitat
            </h2>

            <form method="POST" class="space-y-6">

                <input type="hidden" name="id" value="<?= $habitat['id']; ?>">

                <!-- Nom de l'habitat -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-tag mr-2"></i> Nom de l'habitat
                    </label>
                    <input type="text" 
                           name="nom_habitat"
                           value="<?= htmlspecialchars($habitat['nom_habitat']); ?>" 
                           required
                           class="w-full px-4 py-3 border-2 border-purple-200 rounded-xl 
                                  focus:border-purple-500 focus:outline-none transition"
                           placeholder="Ex : Savane, Jungle, Désert...">
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-align-left mr-2"></i> Description
                    </label>
                    <textarea name="description_habitat" 
                              required
                              class="w-full px-4 py-3 border-2 border-purple-200 rounded-xl 
                                     focus:border-purple-500 focus:outline-none transition"
                              rows="5"
                              placeholder="Décrire l'habitat..."><?= htmlspecialchars($habitat['description_habitat']); ?></textarea>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4">
                    <button type="submit"
                        name="modifier_habitat"
                        class="flex-1 bg-gradient-to-r from-purple-500 to-indigo-600 
                               text-white font-bold py-4 rounded-xl shadow-lg 
                               hover:from-purple-600 hover:to-indigo-700 transition">
                        <i class="fas fa-save mr-2"></i>Enregistrer
                    </button>

                    <a href="../index.php"
                       class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold 
                              py-4 rounded-xl text-center transition">
                        <i class="fas fa-times mr-2"></i>Annuler
                    </a>
                </div>

            </form>
        </div>
    </main>

</body>
</html>
