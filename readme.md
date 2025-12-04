# 🏋️‍♂️ Gestion des Cours & Équipements — Salle de Sport  
Application PHP/MySQL avec Dashboard, CRUD, Graphiques et Export PDF/CSV

---

## 📌 Contexte du Projet
Ce projet a été développé pour une société souhaitant gérer les **cours** et **équipements** d’une salle de sport.

L'application permet :
- Gestion complète des cours  
- Gestion complète des équipements  
- Dashboard statistique  
- Graphiques dynamiques  
- Export PDF
- Table associative entre cours & équipements 
- Authentification simple  

---

# 📁 Fonctionnalités

## 🎯 1. Modélisation (ERD)
La base de données comprend 3 tables principales :
- `cours`
- `equipements`
- `cours_equipements` 

Le fichier **database.sql** contient :
- Création des tables  
- Contraintes et relations  
- Types SQL appropriés  

---

## 📊 2. Dashboard
Le tableau de bord affiche :
- 🔢 Nombre total de cours  
- 🔢 Nombre total d’équipements  
- 📈 Répartition des cours par catégorie  
- 📊 Répartition des équipements par type  
- Graphiques réalisés avec **Chart.js**

---

## 📝 3. Gestion des Cours (CRUD)
Fonctionnalités :
- Affichage des cours dans un tableau  
- Ajout d’un nouveau cours  
- Modification d’un cours  
- Suppression d’un cours  
- Validation des champs obligatoires  

Champs présents :
- nom  
- catégorie  
- date  
- heure  
- durée  
- nombre maximum de participants  

---

## 🧰 4. Gestion des Équipements (CRUD)
Champs :
- nom  
- type  
- quantité disponible  
- état (bon / moyen / à remplacer)

Fonctionnalités :
- Liste des équipements  
- Ajout  
- Modification  
- Suppression  
- Validation  

---

## 🔗 5. Table Associative (Bonus) — `cours_equipements`
Permet :
- Associer plusieurs équipements à un cours  
- Supprimer une association  
- Filtrer les cours selon l’équipement  
- Filtrer les équipements selon les cours associés  

---

## 📤 6. Export PDF / CSV
L'application permet :
- Export des cours  
- Export des équipements  
- Export des liens cours ↔ équipements  
- Export PDF via **DomPDF**  


---

## 🔐 7. Authentification
Sécurisation de l’application avec :
- Login  
- Register  
- Sessions PHP  

---

# 🧱 Technologies utilisées

### Backend
- PHP 8.3+
- mysqli
- DomPDF

### Frontend
- HTML5
- CSS3 / Bootstrap 5
- Chart.js
- DataTables.js

### Base de données
- MySQL 8.x

### Autre
- Docker (PHP + Apache + MySQL + phpMyAdmin)

---

# 🐳 Dockerisation (incluse)

Le projet inclut :
- `docker-compose.yml`
- `Dockerfile`
- Configuration Apache (`vhost.conf`)
- Volume MySQL persistant  
- phpMyAdmin

### Lancer le projet  
```bash
docker-compose build
docker-compose up -d
