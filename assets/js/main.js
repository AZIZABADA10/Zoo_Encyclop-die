// Modal Functions
function openModal(modalId) {
    document.getElementById(modalId).classList.add('active');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('active');
    if (modalId === 'addAnimalModal') {
        document.getElementById('animalForm').reset();
        document.getElementById('animalId').value = '';
        document.getElementById('modalTitle').textContent = 'Ajouter un Animal';
        document.getElementById('imagePreview').innerHTML = `
                    <i class="fas fa-cloud-upload-alt text-6xl text-purple-300 mb-2"></i>
                    <p class="text-gray-600">Cliquez pour télécharger une image</p>
                `;
    }
}

// Image Preview
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('imagePreview').innerHTML = `
                        <img src="${e.target.result}" class="max-h-48 mx-auto rounded-lg shadow-lg">
                    `;
        }
        reader.readAsDataURL(file);
    }
}

// Edit Animal
function editAnimal(id, nom, type, habitat, image) {
    document.getElementById('animalId').value = id;
    document.getElementById('animalNom').value = nom;
    document.getElementById('animalType').value = type;
    document.getElementById('animalHabitat').value = habitat;
    document.getElementById('modalTitle').textContent = 'Modifier l\'Animal';

    if (image) {
        document.getElementById('imagePreview').innerHTML = `
                    <img src="${image}" class="max-h-48 mx-auto rounded-lg shadow-lg">
                `;
    }

    openModal('addAnimalModal');
}

// Delete Animal (PHP will handle this)
function deleteAnimal(id, nom) {
    if (confirm(`Êtes-vous sûr de vouloir supprimer ${nom} ?`)) {
        // Submit form to PHP backend
        const form = document.createElement('form');
        form.method = 'POST';
        form.innerHTML = `<input type="hidden" name="delete_id" value="${id}">`;
        document.body.appendChild(form);
        form.submit();
    }
}

// Filters (JavaScript side - PHP will handle actual filtering)
document.getElementById('searchInput').addEventListener('input', filterAnimals);
document.getElementById('habitatFilter').addEventListener('change', filterAnimals);
document.getElementById('typeFilter').addEventListener('change', filterAnimals);

function filterAnimals() {
    // This will be handled by PHP backend
    // You can implement AJAX calls here if needed
    console.log('Filters applied');
}

// Load statistics (will be populated by PHP)
function updateStatistics(total, carnivores, herbivores, omnivores) {
    document.getElementById('totalAnimals').textContent = total;
    document.getElementById('totalCarnivores').textContent = carnivores;
    document.getElementById('totalHerbivores').textContent = herbivores;
    document.getElementById('totalOmnivores').textContent = omnivores;
}

// Example Animal Card (Template for PHP to use)
function createAnimalCard(animal) {
    const habitatClass = `gradient-${animal.habitat}`;
    return `
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden card-hover slide-in">
                    <div class="${habitatClass} h-48 flex items-center justify-center">
                        <img src="${animal.image}" alt="${animal.nom}" class="h-full w-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">${animal.nom}</h3>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-semibold">
                                <i class="fas fa-utensils mr-1"></i>${animal.type_alimentaire}
                            </span>
                        </div>
                        <div class="flex items-center gap-2 mb-4">
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                                <i class="fas fa-tree mr-1"></i>${animal.habitat}
                            </span>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="editAnimal(${animal.id}, '${animal.nom}', '${animal.type_alimentaire}', '${animal.habitat}', '${animal.image}')" 
                                    class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg transition">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteAnimal(${animal.id}, '${animal.nom}')" 
                                    class="flex-1 bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg transition">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
}
