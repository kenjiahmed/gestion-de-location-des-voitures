# Rent Cars - Location de Voitures de Luxe

Une application web complète de location de voitures développée avec Symfony 7.3.

## 🚀 Fonctionnalités

### Pour les Utilisateurs
- **Catalogue de véhicules** avec recherche et filtres avancés
- **Détails des véhicules** avec galerie d'images
- **Système de réservation** complet avec validation des dates
- **Gestion des réservations** personnelles (voir, annuler)
- **Inscription et connexion** sécurisées
- **Interface responsive** et moderne

### Pour les Administrateurs
- **Tableau de bord** avec statistiques en temps réel
- **Gestion complète des véhicules** (CRUD)
- **Gestion des réservations** et des utilisateurs
- **Gestion des marques et catégories**
- **Interface d'administration** intuitive

## 🛠️ Technologies Utilisées

- **Backend**: Symfony 7.3, PHP 8.2+
- **Base de données**: SQLite (développement)
- **Frontend**: Bootstrap 5, Font Awesome, Twig
- **Authentification**: Symfony Security
- **Pagination**: KnpPaginatorBundle
- **Fixtures**: DoctrineFixturesBundle

## 📦 Installation

1. **Cloner le projet**
   ```bash
   git clone <repository-url>
   cd rent_cars
   ```

2. **Installer les dépendances**
   ```bash
   composer install
   ```

3. **Configurer la base de données**
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:schema:create
   ```

4. **Charger les données de test**
   ```bash
   php bin/console doctrine:fixtures:load
   ```

5. **Lancer le serveur de développement**
   ```bash
   symfony server:start
   # ou
   php -S localhost:8000 -t public
   ```

## 👤 Comptes de Test

### Administrateur
- **Email**: admin@rentcars.com
- **Mot de passe**: admin123

### Utilisateurs
- **Email**: john.doe@email.com
- **Mot de passe**: password123

## 🗂️ Structure du Projet

```
src/
├── Controller/           # Contrôleurs
│   ├── AdminController.php
│   ├── CatalogueController.php
│   ├── HomeController.php
│   ├── RegistrationController.php
│   ├── ReservationController.php
│   └── SecurityController.php
├── Entity/              # Entités Doctrine
│   ├── Brand.php
│   ├── Category.php
│   ├── Image.php
│   ├── Reservation.php
│   ├── User.php
│   └── Vehicule.php
├── Form/                # Formulaires Symfony
│   ├── RegistrationFormType.php
│   ├── ReservationFormType.php
│   └── VehicleFormType.php
├── Repository/          # Repositories Doctrine
└── Security/           # Configuration de sécurité
```

## 🎯 Fonctionnalités Principales

### Système de Réservation
- Validation des dates de disponibilité
- Calcul automatique du prix total
- Gestion des statuts de réservation
- Interface utilisateur intuitive

### Gestion des Véhicules
- Support multi-marques et catégories
- Galerie d'images pour chaque véhicule
- Filtres avancés (prix, marque, catégorie)
- Recherche textuelle

### Administration
- Dashboard avec statistiques
- CRUD complet pour tous les éléments
- Gestion des utilisateurs et réservations
- Interface responsive

## 🔧 Configuration

### Variables d'environnement
Créer un fichier `.env.local` avec :
```env
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
```

### Images
Placer les images des véhicules dans `public/images/vehicles/`

## 📱 Responsive Design

L'application est entièrement responsive et s'adapte à tous les écrans :
- Mobile (< 768px)
- Tablette (768px - 1024px)
- Desktop (> 1024px)

## 🚀 Déploiement

1. Configurer la base de données de production
2. Mettre à jour les variables d'environnement
3. Exécuter les migrations
4. Charger les fixtures (optionnel)
5. Configurer le serveur web

## 📄 Licence

Ce projet est sous licence MIT.

## 👨‍💻 Développement

Pour contribuer au projet :
1. Fork le repository
2. Créer une branche feature
3. Commiter les changements
4. Pousser vers la branche
5. Ouvrir une Pull Request

## 📞 Support

Pour toute question ou problème, ouvrir une issue sur GitHub.
