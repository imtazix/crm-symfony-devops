# 📦 CRM Symfony DevOps

Ce projet est une application CRM développée en **Symfony 7.2** avec une architecture moderne et un environnement de développement complet avec **Docker, Nginx, MySQL et Maildev**.

---

## 🔧 Fonctionnalités

- Authentification avec formulaire sécurisé
- Gestion des utilisateurs avec rôles
- Création, modification et suppression de **clients**
- Affectation de **factures** à des clients (CRUD complet)
- Interface utilisateur stylisée avec **Bootstrap**
- Configuration DevOps avec :
  - Docker
  - Nginx
  - MySQL
 

---

## 📁 Structure du projet

- `src/Entity` : Entités Doctrine (User, Client, Facture)
- `src/Service` : Services métier (ClientService, FactureService)
- `src/Dto` : Objets de transfert de données (DTO)
- `src/Form` : Formulaires Symfony
- `templates/` : Fichiers Twig avec `base.html.twig`
- `nginx/default.conf` : Configuration du serveur Nginx
- `Dockerfile` : Image PHP/Symfony
- `docker-compose.yml` : Lancement de l’environnement complet

---

## 🚀 Lancer le projet

### 1. Cloner le repo

```bash
git clone https://github.com/imtazix/crm-symfony-devops.git
cd crm-symfony-devops
