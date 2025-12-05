<?php
require_once __DIR__ . '/../config/connexion.php';

 if (isset($_GET['id_a_modifier'])) { 
    $id = intval($_GET['id_a_modifier']);
    $sql = "SELECT * FROM animal where id = $id";
    $animal = $connexion -> query($sql) -> fetch_assoc();

    if (isset($_POST['nom']) &&
        isset($_POST['type_alimentaire']) &&
        isset($_POST['habitat']) ) {

        $nom = $_POST['nom'] ;
        $type_alimentaire = $_POST['type_alimentaire'];
        $habitat = intval($_POST['habitat']) ;
        $image = $animal['image_animal'];

        if (!empty($_FILES['image']['tmp_name'])) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $image = uniqid() . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../upload/' . $image);
        }

        $requet_modifier ="UPDATE animal 
        SET nom = '$nom',
        type_alimentaire = '$type_alimentaire',
        image_animal = '$image',
        id_habitat = $habitat
        WHERE id = '$id';
        ";
        $connexion -> query($requet_modifier);
        header("Location: ../index.php");
        exit();
    }
  }else {
    echo "<script>alert('Il faut remplir tous les champs'); window.history.back();</script>";

  }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Animal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../assets/style/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-purple-500 text-white shadow-md">
        <div class="container mx-auto px-6 py-6 flex items-center justify-between">
            <h1 class="text-3xl font-bold flex items-center">
                <i class="fas fa-paw text-3xl md:text-5xl float-animation"></i>
                Gestion des Animaux
            </h1>
            <a href="../index.php" class="bg-white text-purple-500 px-4 py-2 rounded-xl font-semibold hover:bg-purple-100 transition">Retour</a>
        </div>
    </header>

    <!-- Main content -->
    <main class="flex-1 container mx-auto px-6 py-10">
        <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-3xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-800 mb-8 flex items-center">
                <i class="fas fa-edit text-purple-500 mr-3"></i>
                Modifier un Animal
            </h2>

            <form id="animalForm" method="POST" enctype="multipart/form-data" class="space-y-6">
                <input type="hidden" id="animalId" name="id">

                <!-- Nom -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-tag mr-2"></i>Nom de l'animal
                    </label>
                    <input type="text" name="nom" value="<?= $animal['nom'] ?>" id="animalNom" required 
                           class="w-full px-4 py-3 border-2 border-purple-200 rounded-xl focus:border-purple-500 focus:outline-none transition"
                           placeholder="Ex: Lion, Éléphant...">
                </div>

                <!-- Type alimentaire -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-utensils mr-2"></i>Type Alimentaire
                    </label>
                    <select name="type_alimentaire" id="animalType" required 
                            class="w-full px-4 py-3 border-2 border-purple-200 rounded-xl focus:border-purple-500 focus:outline-none transition">
                        <option value="">Sélectionner...</option>
                        <option value="carnivore" <?= $animal['type_alimentaire']=="carnivore"?"selected":"" ?>>🥩 Carnivore</option>
                        <option value="herbivore" <?= $animal['type_alimentaire']== "herbivore"?"selected":"" ?>>🌿 Herbivore</option>
                        <option value="omnivore" <?=  $animal['type_alimentaire'] =="Omnivore"?"selected":"" ?>>🍽️ Omnivore</option>
                    </select>
                </div>

                <!-- Habitat -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-tree mr-2"></i>Habitat
                    </label>
                    <select name="habitat" id="animalHabitat" required 
                            class="w-full px-4 py-3 border-2 border-purple-200 rounded-xl focus:border-purple-500 focus:outline-none transition">
                        <option value="" >Sélectionner...</option>
                        <option value="1" <?= $animal['id_habitat'] == '1'?"selected":"" ?>>🦁 Savane</option>
                        <option value="2" <?= $animal['id_habitat'] == '2'? "selected":"" ?>>🌴 Jungle</option>
                        <option value="4" <?= $animal['id_habitat'] == '3' ? "selected" : ""?>>🏜️ Désert</option>
                        <option value="3" <?= $animal['id_habitat']  == '4' ? "selected":""?> >🌊 Océan</option>
                    </select>
                </div>

                <!-- Image -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-image mr-2"></i>Image de l'animal
                    </label>
                    <div class="border-2 border-dashed border-purple-300 rounded-xl p-6 text-center hover:border-purple-500 transition cursor-pointer">
                        <input type="file" name="image" id="animalImage" accept="image/*" 
                               class="hidden" onchange="previewImage(event)">
                        <label for="animalImage" class="cursor-pointer">
                            <div id="imagePreview" class="mb-4">
                                <i class="fas fa-cloud-upload-alt text-6xl text-purple-300 mb-2"></i>
                                <p class="text-gray-600">Cliquez pour télécharger une image</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-bold py-4 rounded-xl shadow-lg hover:from-purple-600 hover:to-indigo-700 transition">
                        <i class="fas fa-save mr-2"></i>Enregistrer
                    </button>
                    <a href="../index.php" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-4 rounded-xl text-center transition">
                        <i class="fas fa-times mr-2"></i>Annuler
                    </a>
                </div>
            </form>
        </div>
    </main>

    <script>
        // Prévisualisation de l'image
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('imagePreview');
                output.innerHTML = `<img src="${reader.result}" class="mx-auto rounded-xl max-h-64">`;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>
