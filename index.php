<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoo Kids - Gestion des Animaux</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
        .slide-in {
            animation: slideIn 0.6s ease-out;
        }
        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .gradient-savane {
            background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
        }
        .gradient-jungle {
            background: linear-gradient(135deg, #56ab2f 0%, #a8e063 100%);
        }
        .gradient-desert {
            background: linear-gradient(135deg, #f09819 0%, #edde5d 100%);
        }
        .gradient-ocean {
            background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%);
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            z-index: 1000;
            animation: fadeIn 0.3s ease;
        }
        .modal.active {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            animation: slideIn 0.4s ease;
        }
        .btn-primary {
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }
    </style>
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
                        <h3 class="text-4xl font-bold" id="totalAnimals">0</h3>
                    </div>
                    <i class="fas fa-dragon text-5xl opacity-50"></i>
                </div>
            </div>
            <div class="bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl p-6 text-white shadow-xl card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100 text-sm">Carnivores</p>
                        <h3 class="text-4xl font-bold" id="totalCarnivores">0</h3>
                    </div>
                    <i class="fas fa-drumstick-bite text-5xl opacity-50"></i>
                </div>
            </div>
            <div class="bg-gradient-to-br from-green-400 to-teal-500 rounded-2xl p-6 text-white shadow-xl card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm">Herbivores</p>
                        <h3 class="text-4xl font-bold" id="totalHerbivores">0</h3>
                    </div>
                    <i class="fas fa-leaf text-5xl opacity-50"></i>
                </div>
            </div>
            <div class="bg-gradient-to-br from-blue-400 to-indigo-500 rounded-2xl p-6 text-white shadow-xl card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm">Omnivores</p>
                        <h3 class="text-4xl font-bold" id="totalOmnivores">0</h3>
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
                    <select id="habitatFilter" class="w-full px-4 py-3 border-2 border-purple-200 rounded-xl focus:border-purple-500 focus:outline-none transition">
                        <option value="">Tous les habitats</option>
                        <option value="savane">Savane</option>
                        <option value="jungle">Jungle</option>
                        <option value="desert">Désert</option>
                        <option value="ocean">Océan</option>
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
            <!-- Animals will be loaded here dynamically via PHP -->
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
                        <option value="">Sélectionner...</option>
                        <option value="savane">🦁 Savane</option>
                        <option value="jungle">🌴 Jungle</option>
                        <option value="desert">🏜️ Désert</option>
                        <option value="ocean">🌊 Océan</option>
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