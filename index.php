<?php
require_once 'config/connexion.php';
require_once 'actions/ajouter_animal.php';
require_once 'actions/statistiques.php';
require_once 'actions/supprimer_animal.php';


/** Récuperation des donnée des animaux */
$requet_sql = "SELECT a.*, h.nom_habitat, h.id AS id_habitat
               FROM animal a
               JOIN habitats h ON a.id_habitat = h.id
               WHERE 1000=1000
               ";



// Récupération des habitats pour les selects
$habitats_result = $connexion->query("SELECT * FROM habitats ORDER BY nom_habitat");
$habitats = [];
while ($h = $habitats_result->fetch_assoc()) {
    $habitats[] = $h;
}



/** filtrage par type alimentaire */
$filter_par_type_alimentaire = isset($_GET['filter_par_type_alimentaire'])? $_GET['filter_par_type_alimentaire'] : '';
if(!empty($filter_par_type_alimentaire)){
    $requet_sql .= " AND a.type_alimentaire like '%$filter_par_type_alimentaire%'";
};

/** filtrer par habitats */
$filter_par_habitat = isset($_GET['filter_par_habitat']) ? $_GET['filter_par_habitat'] : '';
if (!empty($_GET['filter_par_habitat'])) {
    $requet_sql .= " AND h.nom_habitat like '%$filter_par_habitat%'";
};

$animaux = $connexion->query($requet_sql);

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
    <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">
</head>
<body class="bg-gradient-to-br from-purple-50 to-blue-50 min-h-screen">
    <!-- Header -->
        <header class="gradient-bg text-white shadow-2xl">
            <div class="container mx-auto px-4 py-4 md:py-6">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4 md:gap-0">
                    <!-- Logo et titre -->
                    <div class="flex items-center space-x-3 md:space-x-4 slide-in w-full md:w-auto">
                        <i class="fas fa-paw text-3xl md:text-5xl float-animation"></i>
                        <div class="flex-1 md:flex-none">
                            <h1 class="text-2xl md:text-4xl font-bold leading-tight">Zoo Kids</h1>
                            <p class="text-purple-200 text-sm md:text-base">Apprends et découvre les animaux !</p>
                        </div>
                    </div>

                    <!-- Bouton responsive -->
                    <div class="flex gap-4">
                        <button onclick="openModal('addAnimalModal')" 
                            class="btn-primary bg-gradient-to-r from-yellow-400 to-amber-400 hover:from-yellow-500 hover:to-amber-500 
                                text-purple-900 font-bold py-2 px-4 md:py-3 md:px-6 rounded-full shadow-lg hover:shadow-xl 
                                transform hover:-translate-y-1 transition-all duration-300 w-full md:w-auto 
                                flex items-center justify-center gap-2">
                        <i class="fas fa-plus text-sm md:text-base"></i>
                        <span class="text-sm md:text-base">Ajouter un Animal</span>
                    </button>
                    <button onclick="openModal('habitatModalAdd')" 
                        class="btn-primary bg-gradient-to-r from-yellow-400 to-amber-400 hover:from-yellow-500 hover:to-amber-500 
                                text-purple-900 font-bold py-2 px-4 md:py-3 md:px-6 rounded-full shadow-lg hover:shadow-xl 
                                transform hover:-translate-y-1 transition-all duration-300 w-full md:w-auto 
                                flex items-center justify-center gap-2">
                        <i class="fas fa-plus"></i> Nouvel Habitat
                    </button>
                    </div>
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
   <div class="bg-gradient-to-r from-white to-purple-50 rounded-3xl shadow-2xl p-6 mb-8 border border-purple-100">
        <form method="GET" class="flex flex-wrap gap-6 items-end">
            <div class="flex-1 min-w-[250px]">
                <label class="block text-gray-800 font-bold mb-3 text-lg">
                    <i class="fas fa-tree mr-2 text-emerald-600"></i>Habitat
                </label>
                <select name="filter_par_habitat" class="w-full px-5 py-3.5 border-2 border-purple-300 rounded-2xl 
                    bg-white text-gray-700 font-medium focus:border-purple-500 focus:ring-4 
                    focus:ring-purple-200 focus:outline-none transition-all duration-300">
                    <option value="">Tous les habitats</option>
                    <?php foreach ($habitats as $h): ?>
                        <option value="<?= $h['nom_habitat'] ?>" 
                            <?= ($_GET['filter_par_habitat'] ?? '') == $h['nom_habitat'] ? "selected" : "" ?>>
                            <?= $h['nom_habitat'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>


            <div class="flex-1 min-w-[250px]">
                <label class="block text-gray-800 font-bold mb-3 text-lg">
                    <i class="fas fa-utensils mr-2 text-amber-600"></i>Type Alimentaire
                </label>
                <select name="filter_par_type_alimentaire"
                        class="w-full px-5 py-3.5 border-2 border-purple-300 rounded-2xl 
                               bg-white text-gray-700 font-medium focus:border-purple-500 
                               focus:ring-4 focus:ring-purple-200 focus:outline-none transition-all duration-300">
                    <option value="" class="py-2">Tous les types</option>
                    <option value="carnivore" <?= ($_GET['filter_par_type_alimentaire'] ?? '')=="carnivore" ? "selected":"" ?>
                            class="py-2 hover:bg-purple-100">Carnivore</option>
                    <option value="herbivore" <?= ($_GET['filter_par_type_alimentaire'] ?? '')=="herbivore" ? "selected":"" ?>
                            class="py-2 hover:bg-purple-100">Herbivore</option>
                    <option value="omnivore"  <?= ($_GET['filter_par_type_alimentaire'] ?? '')=="omnivore"  ? "selected":"" ?>
                            class="py-2 hover:bg-purple-100">Omnivore</option>
                </select>
            </div>

            <button type="submit" 
                    class="px-8 py-3.5 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 
                           hover:to-indigo-700 text-white font-bold rounded-2xl shadow-lg hover:shadow-xl 
                           transform hover:-translate-y-0.5 transition-all duration-300">
                <i class="fas fa-filter mr-2"></i>Filtrer
            </button>
        </form>
    </div>
        <!-- Animals Grid -->
         <h2 class="text-3xl font-bold text-gray-900 mb-6">Nos Animaux</h2> 
        <div id="animalsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
          
        <?php while ($animal = $animaux->fetch_assoc()): ?>
            <div class="group bg-white rounded-3xl shadow-xl overflow-hidden relative 
                    hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
            
            <!-- Image avec effet de zoom et overlay -->
            <div class="h-48 overflow-hidden relative">
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent 
                            opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-10"></div>
                <img src="uploads/<?php echo $animal['image_animal']; ?>" 
                    class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-700">
            </div>

            <!-- Contenu avec animations -->
            <div class="p-6 relative">
                <!-- Nom avec effet underline -->
                <h3 class="text-2xl font-bold text-gray-900 mb-3 relative inline-block 
                        after:content-[''] after:absolute after:w-0 after:h-1 after:bg-gradient-to-r after:from-purple-500 after:to-blue-500 
                        after:left-0 after:-bottom-1 after:transition-all after:duration-500 group-hover:after:w-full">
                    <?php echo $animal['nom']; ?>
                </h3>

                <!-- Badges avec animation de scale -->
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="inline-flex items-center gap-1 bg-gradient-to-r from-purple-50 to-white 
                                text-purple-700 px-4 py-2 rounded-full text-sm font-semibold 
                                border border-purple-200 shadow-sm hover:scale-105 transition-transform duration-300">
                        <i class="fas fa-utensils text-purple-600"></i>
                        <?php echo $animal['type_alimentaire']; ?>
                    </span>
                    
                    <span class="inline-flex items-center gap-1 bg-gradient-to-r from-emerald-50 to-white 
                                text-emerald-700 px-4 py-2 rounded-full text-sm font-semibold 
                                border border-emerald-200 shadow-sm hover:scale-105 transition-transform duration-300">
                        <i class="fas fa-tree text-emerald-600"></i>
                        <?php echo $animal['nom_habitat']; ?>
                    </span>
                </div>

                <!-- Boutons avec animation glissante -->
                <div class="flex gap-3 mt-6">
                    <button  
                            class="flex-1 flex items-center justify-center gap-2 bg-gradient-to-r from-blue-500 to-cyan-500 
                                text-white font-medium py-3 rounded-xl hover:from-blue-600 hover:to-cyan-600 
                                hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300 
                                group/btn">
                        <i class="fas fa-edit group-hover/btn:rotate-12 transition-transform duration-300"></i>
                        <span class="group-hover/btn:translate-x-1 transition-transform duration-300"><a href="actions/modifier_animal.php?id_a_modifier=<?= $animal['id']; ?>">Modifier</a></span>
                    </button>
                    
                    <button
                            class="flex-1 flex items-center justify-center gap-2 bg-gradient-to-r from-red-500 to-rose-500 
                                text-white font-medium py-3 rounded-xl hover:from-red-600 hover:to-rose-600 
                                hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300 
                                group/btn">
                        <i class="fas fa-trash group-hover/btn:rotate-12 transition-transform duration-300"></i>
                            <span class="group-hover/btn:translate-x-1 transition-transform duration-300">
                                <a href="actions/supprimer_animal.php?supprimer=<?php echo $animal['id']; ?>" 
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet animal ?');">
                                Supprimer
                                </a>
                            </span> 
                    </button>
                </div>
            </div>

            <!-- Effet de bordure animé -->
            <div class="absolute inset-0 rounded-3xl border-2 border-transparent 
                        group-hover:border-purple-200 transition-all duration-500 pointer-events-none"></div>
        </div>
                <?php endwhile; ?>
                </div>
        </div>
            <!-- Habitats Grid -->
            <div class="container mx-auto px-4 py-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Nos Habitats</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($habitats as $habitat): ?>
                    <div class="group bg-white rounded-3xl shadow-xl overflow-hidden relative 
                                hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 p-6">
                        
                        <!-- Nom de l'habitat -->
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">
                            <?= $habitat['nom_habitat']; ?>
                        </h3>

                        <!-- Description -->
                        <p class="text-gray-700 mb-4"><?= $habitat['description_habitat']; ?></p>

                        <!-- Boutons Modifier / Supprimer -->
                        <div class="flex gap-3">
                            <a href="actions/modifier_habitat.php?id=<?= $habitat['id']; ?>" 
                            class="flex-1 flex items-center justify-center gap-2 bg-blue-500 text-white py-3 rounded-xl hover:bg-blue-600 transition">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <a href="actions/supprimer_habitat.php?supprimer=<?= $habitat['id']; ?>" 
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet habitat ?');"
                            class="flex-1 flex items-center justify-center gap-2 bg-red-500 text-white py-3 rounded-xl hover:bg-red-600 transition">
                                <i class="fas fa-trash"></i> Supprimer
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
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
                                <option value="" disabled selected>Sélectionner...</option>
                                <?php foreach ($habitats as $h): ?>
                                    <option value="<?= $h['id'] ?>"><?= $h['nom_habitat'] ?></option>
                                <?php endforeach; ?>
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
            <div id="habitatModalAdd" class="modal">
            <div class="modal-content bg-white p-8 rounded-2xl">

                <h2 class="text-2xl font-bold mb-4">Ajouter un Habitat</h2>
                <button onclick="closeModal('habitatModalAdd')" class="text-gray-500 text-xl">
                    <i class="fas fa-times"></i>
                </button>

                <form method="POST" action="actions/ajouter_habitat.php">
                    <label>Nom de l'habitat</label>
                    <input type="text" name="nom_habitat" required class="w-full border p-3 rounded mb-4">

                    <label>Description</label>
                    <textarea name="description_habitat" required class="w-full border p-3 rounded mb-4"></textarea>

                    <button type="submit" name="ajouter_habitat"
                        class="w-full bg-green-600 text-white py-3 rounded-xl">
                        Ajouter
                    </button>
                </form>

            </div>
        </div>


<footer class="bg-purple-500 text-white py-10 mt-10 fade-in-up">
    <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8">

        <!-- Logo + description -->
        <div class="transform transition duration-300 hover:scale-105">
            <h2 class="text-2xl font-bold mb-3">Zoo Kids</h2>
            <p class="text-sm text-purple-200">
                Apprends, découvre et explore le monde des animaux de manière amusante !
            </p>
        </div>

        <!-- Liens rapides -->
        <div class="transform transition duration-300 hover:scale-105">
            <h3 class="text-xl font-semibold mb-4">Liens rapides</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="#" class="hover:text-yellow-300 transition">Accueil</a></li>
                <li><a href="#" class="hover:text-yellow-300 transition">Animaux</a></li>
                <li><a href="#" class="hover:text-yellow-300 transition">Habitats</a></li>
                <li><a href="#" class="hover:text-yellow-300 transition">Contact</a></li>
            </ul>
        </div>

        <!-- Contact -->
        <div class="transform transition duration-300 hover:scale-105">
            <h3 class="text-xl font-semibold mb-4">Contact</h3>
            <ul class="space-y-3 text-sm">
                <li>📍 123 Parc Zoologique, Maroc</li>
                <li>📞 +212 6 12 34 56 78</li>
                <li>✉️ contact@zookids.com</li>
            </ul>
        </div>

    </div>

    <!-- Bas du footer -->
    <div class="mt-10 border-t border-purple-300 pt-5 text-center text-sm fade-in-up">
        © 2024 Zoo Kids — Tous droits réservés.
    </div>
</footer>

    <script src="assets/js/main.js"></script>
</body>
</html>