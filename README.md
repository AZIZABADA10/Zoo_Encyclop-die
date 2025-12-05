````md
#  Mini Site Web Zoo Éducatif pour Enfants

Ce projet a pour objectif d’aider les tout-petits d’une crèche à mémoriser et apprendre les animaux du zoo à travers un site web simple, interactif et ludique.  
Il permet de gérer les animaux, leurs habitats, leurs types alimentaires ainsi que leurs images.

---

##  Fonctionnalités principales

### Concepteur
- Diagramme de cas d’utilisation (Use Case) :  
  - Ajouter un animal  
  - Modifier / supprimer un animal  
  - Afficher les animaux avec images  
  - Ajouter un habitat  
  - Modifier / supprimer un habitat  
- Diagramme ERD (Base de données)

### Développeur Back-End
- Création de la base de données (animal & habitats)
- Requêtes SQL CRUD :
  - Ajouter un animal / habitat  
  - Modifier un animal / habitat  
  - Supprimer un animal  
  - Afficher les animaux avec leurs détails et images

### Développeur Front-End
- Interface simple et adaptée aux enfants
- Technologies utilisées :
  - **HTML**
  - **TailwindCSS**
  - **JavaScript**
  - **PHP**

### Filtres
- Recherche d’animaux par :
  - Habitat
  - Type alimentaire (Carnivore, Herbivore, Omnivore)

### Statistiques
- Graphiques via JavaScript (Chart.js) :
  - Nombre d’animaux par habitat  
  - Nombre d’animaux par type alimentaire

---

# Base de données

## Table `habitats`
| Champ                  | Type        | Description          |
|-----------------------|-------------|----------------------|
| id                    | INT (PK AI) | Identifiant habitat  |
| nom_habitat           | VARCHAR     | Nom de l’habitat     |
| description_habitat   | TEXT        | Description          |

## Table `animal`
| Champ             | Type        | Description                         |
|------------------|-------------|-------------------------------------|
| id               | INT (PK AI) | Identifiant animal                  |
| nom              | VARCHAR     | Nom de l’animal                     |
| type_alimentaire | VARCHAR     | Carnivore / Herbivore / Omnivore    |
| id_habitat       | INT (FK)    | Lien habitat                        |
| image            | VARCHAR     | URL ou chemin image                 |

---

# PHP (CRUD)

* Connexion via PDO
* Formulaires d’ajout, modification et suppression
* Téléchargement & affichage des images
* Filtres dynamiques
* Sécurité via requêtes préparées


---

# Installation

1. Cloner le projet
2. Importer la base de données (fichier `.sql`)
3. Configurer `config/connexion.php` :


---

# Objectif final

Créer un site amusant et éducatif qui permet aux enfants de découvrir :
- les animaux
- leurs habitats
- leurs types alimentaires
- avec des images et des interactions simples

---
# ATEUR: ABADA AZIZ Développeur web full stack 
