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


