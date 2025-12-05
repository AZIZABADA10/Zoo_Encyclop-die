#  Mini Site Web Zoo Éducatif pour Enfants

Ce projet a pour objectif d’aider les tout-petits d’une crèche à mémoriser et apprendre les animaux du zoo à travers un site web simple, interactif et ludique.  
Il permet de gérer les animaux, leurs habitats, leurs types alimentaires ainsi que leurs images.

---

##  Fonctionnalités principales

###  Concepteur
- Création du diagramme de cas d’utilisation (Use Case) :
  - Ajouter un animal  
  - Modifier / supprimer un animal  
  - Afficher les animaux avec leurs images  
  - Ajouter un habitat  
  - Modifier / supprimer un habitat  
- Création du diagramme ERD (Base de données)

### Développeur Back-End
- Mise en place de la base de données (`animal` & `habitats`)
- Implémentation des requêtes SQL CRUD :
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

###  Filtres
- Recherche d’animaux par :
  - Habitat
  - Type alimentaire (Carnivore, Herbivore, Omnivore)

### Statistiques
- Graphiques réalisés avec **Chart.js** :
  - Nombre d’animaux par habitat  
  - Nombre d’animaux par type alimentaire  

---

# Base de données

## Table `habitats`
| Champ                | Type        | Description           |
|---------------------|-------------|------------------------|
| id                  | INT (PK AI) | Identifiant habitat    |
| nom_habitat         | VARCHAR     | Nom de l’habitat       |
| description_habitat | TEXT        | Description            |

## Table `animal`
| Champ             | Type        | Description                       |
|------------------|-------------|-----------------------------------|
| id               | INT (PK AI) | Identifiant animal                |
| nom              | VARCHAR     | Nom de l’animal                   |
| type_alimentaire | VARCHAR     | Carnivore / Herbivore / Omnivore  |
| id_habitat       | INT (FK)    | Lien vers l’habitat               |
| image            | VARCHAR     | URL ou chemin de l’image          |

---

# PHP (CRUD)

- Connexion à la base via **PDO**
- Formulaires d’ajout, modification et suppression
- Téléchargement & affichage des images
- Filtres dynamiques (habitat & type alimentaire)
- Sécurité via requêtes préparées (`prepare()`, `bindParam()`)

---

# Auteur: ABADA AZIZ Développeur Web Full Stack



