<?php
require_once 'config/connexion.php';
require_once 'actions/ajouter_animal.php';

/** Récuperation des donnée des animaux */
$animaux = $connexion -> query("select *,nom_habitat from animal a,habitats h where a.id_habitat = h.id;");
/**Calcule de statistique des animaux */
$total_animaux = $connexion -> query("select count(*) as total from animal;");
$res = $total_animaux -> fetch_assoc();

/** total des carnivors */
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
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoo Kids - Gestion des Animaux</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/style/styles.css">
</head>
<body class="bg-gradient-to-br from-purple-50 to-blue-50 min-h-screen">
    
    <!-- Header -->
    <header class="gradient-bg text-white shadow-2xl">
        <div class="container mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4 slide-in">
                    <i class="fas fa-paw text-5xl float-animation"></i>
                    <div>
                        <h1 class="text-4xl font-bold">Zoo Kids</h1>
                        <p class="text-purple-200">Apprends et découvre les animaux !</p>
                    </div>
                </div>
                <button onclick="openModal('addAnimalModal')" class="btn-primary bg-yellow-400 hover:bg-yellow-500 text-purple-900 font-bold py-3 px-6 rounded-full shadow-lg">
                    <i class="fas fa-plus mr-2"></i>Ajouter un Animal
                </button>
            </div>
        </div>
    </header>
    

        <!-- Statistics Section -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 m-4">
            <div class="bg-gradient-to-br from-pink-400 to-purple-500 rounded-2xl p-6 text-white shadow-xl card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-pink-100 text-sm">Total Animaux</p>
                        <h3 class="text-4xl font-bold" id="totalAnimals"><?php echo $res['total']; ?></h3>
                    </div>
                    <i class="fas fa-dragon text-5xl opacity-50"></i>
                </div>
            </div>
            <div class="bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl p-6 text-white shadow-xl card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100 text-sm">Carnivores</p>
                        <h3 class="text-4xl font-bold" id="totalCarnivores"><?php echo $res_carnivors['total_animaux_carnivors']; ?></h3>
                    </div>
                    <i class="fas fa-drumstick-bite text-5xl opacity-50"></i>
                </div>
            </div>
            <div class="bg-gradient-to-br from-green-400 to-teal-500 rounded-2xl p-6 text-white shadow-xl card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm">Herbivores</p>
                        <h3 class="text-4xl font-bold" id="totalHerbivores"><?php echo $res_herbivors['total_animaux_herbivores']; ?></h3>
                    </div>
                    <i class="fas fa-leaf text-5xl opacity-50"></i>
                </div>
            </div>
            <div class="bg-gradient-to-br from-blue-400 to-indigo-500 rounded-2xl p-6 text-white shadow-xl card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm">Omnivores</p>
                        <h3 class="text-4xl font-bold" id="totalOmnivores"><?php echo $res_omnivores['total_animaux_omnivores'] ?></h3>
                    </div>
                    <i class="fas fa-balance-scale text-5xl opacity-50"></i>
                </div>
            </div>
        </div>

    <!-- Filters Section -->
    <div class="container mx-auto px-4 py-8 fade-in">
        <div class="bg-white rounded-3xl shadow-xl p-6 mb-8">
            <div class="flex flex-wrap gap-4 items-center justify-between">
                <div class="flex-1 min-w-[250px]">
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-search mr-2"></i>Rechercher
                    </label>
                    <input type="text" id="searchInput" placeholder="Nom de l'animal..." 
                           class="w-full px-4 py-3 border-2 border-purple-200 rounded-xl focus:border-purple-500 focus:outline-none transition">
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-tree mr-2"></i>Habitat
                    </label>
                    <select id="habitatFilter" required name="habitat" class="w-full px-4 py-3 border-2 border-purple-200 rounded-xl focus:border-purple-500 focus:outline-none transition">
                        <option value="" >Tous les habitats</option>
                        <option value="1">Savane</option>
                        <option value="2">Jungle</option>
                        <option value="4">Désert</option>
                        <option value="3">Océan</option>
                    </select>
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-utensils mr-2"></i>Type Alimentaire
                    </label>
                    <select id="typeFilter" class="w-full px-4 py-3 border-2 border-purple-200 rounded-xl focus:border-purple-500 focus:outline-none transition">
                        <option value="">Tous les types</option>
                        <option value="carnivore">Carnivore</option>
                        <option value="herbivore">Herbivore</option>
                        <option value="omnivore">Omnivore</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- Animals Grid -->
        <div id="animalsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php while ($animal = $animaux->fetch_assoc()): ?>

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden card-hover slide-in">

                <div class="h-48 flex items-center justify-center">
                    <img src="uploads/<?php echo $animal['image_animal']; ?>" 
                        class="h-full w-full object-cover">
                </div>

                <div class="p-6">

                    <h3 class="text-2xl font-bold text-gray-800 mb-2">
                        <?php echo $animal['nom']; ?>
                    </h3>

                    <div class="flex items-center gap-2 mb-2">
                        <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-semibold">
                            <i class="fas fa-utensils mr-1"></i>
                            <?php echo $animal['type_alimentaire']; ?>
                        </span>
                    </div>

                    <div class="flex items-center gap-2 mb-4">
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                            <i class="fas fa-tree mr-1"></i>
                            <?php echo $animal['nom_habitat']; ?>
                        </span>
                    </div>

                </div>
            </div>

            <?php endwhile; ?>
            </div>
    </div>
    

    <!-- Modal: Add/Edit Animal -->
    <div id="addAnimalModal" class="modal">
        <div class="modal-content bg-white rounded-3xl shadow-2xl p-8 max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-3xl font-bold text-gray-800">
                    <i class="fas fa-paw text-purple-500 mr-3"></i>
                    <span id="modalTitle">Ajouter un Animal</span>
                </h2>
                <button onclick="closeModal('addAnimalModal')" class="text-gray-500 hover:text-gray-700 text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="animalForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="animalId" name="id">
    
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-tag mr-2"></i>Nom de l'animal
                    </label>
                    <input type="text" name="nom" id="animalNom" required 
                           class="w-full px-4 py-3 border-2 border-purple-200 rounded-xl focus:border-purple-500 focus:outline-none transition"
                           placeholder="Ex: Lion, Éléphant...">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-utensils mr-2"></i>Type Alimentaire
                    </label>
                    <select name="type_alimentaire" id="animalType" required 
                            class="w-full px-4 py-3 border-2 border-purple-200 rounded-xl focus:border-purple-500 focus:outline-none transition">
                        <option value="">Sélectionner...</option>
                        <option value="carnivore">🥩 Carnivore</option>
                        <option value="herbivore">🌿 Herbivore</option>
                        <option value="omnivore">🍽️ Omnivore</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-tree mr-2"></i>Habitat
                    </label>
                    <select name="habitat" id="animalHabitat" required 
                            class="w-full px-4 py-3 border-2 border-purple-200 rounded-xl focus:border-purple-500 focus:outline-none transition">
                        <option value="" disabled selected >Sélectionner...</option>
                        <option value="1">🦁 Savane</option>
                        <option value="2">🌴 Jungle</option>
                        <option value="4">🏜️ Désert</option>
                        <option value="3">🌊 Océan</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-image mr-2"></i>Image de l'animal
                    </label>
                    <div class="border-2 border-dashed border-purple-300 rounded-xl p-6 text-center hover:border-purple-500 transition">
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

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 btn-primary bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-bold py-4 rounded-xl shadow-lg">
                        <i class="fas fa-save mr-2"></i>Enregistrer
                    </button>
                    <button type="button" onclick="closeModal('addAnimalModal')" 
                            class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-4 rounded-xl transition">
                        <i class="fas fa-times mr-2"></i>Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Manage Habitats -->
    <button onclick="openModal('habitatModal')" 
            class="fixed bottom-8 right-8 bg-gradient-to-r from-green-500 to-teal-600 text-white p-5 rounded-full shadow-2xl hover:scale-110 transition z-50">
        <i class="fas fa-tree text-2xl"></i>
    </button>

    <div id="habitatModal" class="modal">
        <div class="modal-content bg-white rounded-3xl shadow-2xl p-8 max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-3xl font-bold text-gray-800">
                    <i class="fas fa-tree text-green-500 mr-3"></i>Gestion des Habitats
                </h2>
                <button onclick="closeModal('habitatModal')" class="text-gray-500 hover:text-gray-700 text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="gradient-savane rounded-2xl p-6 text-white shadow-xl">
                    <h3 class="text-2xl font-bold mb-2">🦁 Savane</h3>
                    <p class="mb-4">Grandes plaines herbeuses d'Afrique avec des températures chaudes.</p>
                    <button class="bg-white text-orange-600 px-4 py-2 rounded-lg font-semibold hover:scale-105 transition">
                        <i class="fas fa-edit mr-2"></i>Modifier
                    </button>
                </div>

                <div class="gradient-jungle rounded-2xl p-6 text-white shadow-xl">
                    <h3 class="text-2xl font-bold mb-2">🌴 Jungle</h3>
                    <p class="mb-4">Forêts tropicales denses et humides avec une végétation luxuriante.</p>
                    <button class="bg-white text-green-600 px-4 py-2 rounded-lg font-semibold hover:scale-105 transition">
                        <i class="fas fa-edit mr-2"></i>Modifier
                    </button>
                </div>

                <div class="gradient-desert rounded-2xl p-6 text-white shadow-xl">
                    <h3 class="text-2xl font-bold mb-2">🏜️ Désert</h3>
                    <p class="mb-4">Régions arides et sèches avec peu de végétation et températures extrêmes.</p>
                    <button class="bg-white text-yellow-600 px-4 py-2 rounded-lg font-semibold hover:scale-105 transition">
                        <i class="fas fa-edit mr-2"></i>Modifier
                    </button>
                </div>

                <div class="gradient-ocean rounded-2xl p-6 text-white shadow-xl">
                    <h3 class="text-2xl font-bold mb-2">🌊 Océan</h3>
                    <p class="mb-4">Vastes étendues d'eau salée abritant une vie marine diversifiée.</p>
                    <button class="bg-white text-blue-600 px-4 py-2 rounded-lg font-semibold hover:scale-105 transition">
                        <i class="fas fa-edit mr-2"></i>Modifier
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/main.js"></script>
</body>
</html>