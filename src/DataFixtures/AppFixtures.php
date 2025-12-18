<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Image;
use App\Entity\User;
use App\Entity\Vehicule;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Create brands
        $brands = [
            ['name' => 'BMW', 'logo' => 'bmw-logo.png', 'description' => 'Bayerische Motoren Werke - Luxury German automobiles'],
            ['name' => 'Mercedes-Benz', 'logo' => 'mercedes-logo.png', 'description' => 'German luxury automotive brand'],
            ['name' => 'Audi', 'logo' => 'audi-logo.png', 'description' => 'German luxury car manufacturer'],
            ['name' => 'Porsche', 'logo' => 'porsche-logo.png', 'description' => 'German sports car manufacturer'],
            ['name' => 'Tesla', 'logo' => 'tesla-logo.png', 'description' => 'American electric vehicle manufacturer'],
            ['name' => 'Toyota', 'logo' => 'toyota-logo.png', 'description' => 'Japanese automotive manufacturer'],
            ['name' => 'Honda', 'logo' => 'honda-logo.png', 'description' => 'Japanese multinational automotive manufacturer'],
            ['name' => 'Ford', 'logo' => 'ford-logo.png', 'description' => 'American multinational automotive manufacturer'],
            ['name' => 'Volkswagen', 'logo' => 'vw-logo.png', 'description' => 'German automotive manufacturer'],
            ['name' => 'Nissan', 'logo' => 'nissan-logo.png', 'description' => 'Japanese multinational automotive manufacturer'],
        ];

        $brandEntities = [];
        foreach ($brands as $brandData) {
            $brand = new Brand();
            $brand->setName($brandData['name'])
                  ->setLogo($brandData['logo'])
                  ->setDescription($brandData['description']);
            $manager->persist($brand);
            $brandEntities[] = $brand;
        }

        // Create categories
        $categories = [
            ['name' => 'Berline', 'description' => 'Voitures de luxe 4 portes'],
            ['name' => 'SUV', 'description' => 'Véhicules utilitaires sport'],
            ['name' => 'Coupé', 'description' => 'Voitures sport 2 portes'],
            ['name' => 'Cabriolet', 'description' => 'Voitures décapotables'],
            ['name' => 'Break', 'description' => 'Voitures familiales spacieuses'],
            ['name' => 'Citadine', 'description' => 'Petites voitures urbaines'],
            ['name' => 'Monospace', 'description' => 'Véhicules familiaux 7 places'],
        ];

        $categoryEntities = [];
        foreach ($categories as $categoryData) {
            $category = new Category();
            $category->setName($categoryData['name'])
                     ->setDescription($categoryData['description']);
            $manager->persist($category);
            $categoryEntities[] = $category;
        }

        // Create admin user
        $admin = new User();
        $admin->setEmail('admin@rentcars.com')
              ->setRoles(['ROLE_ADMIN'])
              ->setPassword($this->passwordHasher->hashPassword($admin, 'admin123'))
              ->setFirstName('Admin')
              ->setLastName('System')
              ->setPhone('0123456789')
              ->setCountry('France');
        $manager->persist($admin);

        // Create regular users
        $users = [
            ['email' => 'john.doe@email.com', 'firstName' => 'John', 'lastName' => 'Doe', 'phone' => '0123456789'],
            ['email' => 'jane.smith@email.com', 'firstName' => 'Jane', 'lastName' => 'Smith', 'phone' => '0987654321'],
            ['email' => 'mike.johnson@email.com', 'firstName' => 'Mike', 'lastName' => 'Johnson', 'phone' => '0555666777'],
        ];

        $userEntities = [];
        foreach ($users as $userData) {
            $user = new User();
            $user->setEmail($userData['email'])
                 ->setPassword($this->passwordHasher->hashPassword($user, 'password123'))
                 ->setFirstName($userData['firstName'])
                 ->setLastName($userData['lastName'])
                 ->setPhone($userData['phone'])
                 ->setCountry('France');
            $manager->persist($user);
            $userEntities[] = $user;
        }

        // Create vehicles
        $vehicles = [
            // BMW
            ['brand' => 0, 'model' => 'Série 3', 'year' => 2023, 'price' => 120, 'category' => 0, 'color' => 'Blanc', 'fuel' => 'essence', 'seats' => 5, 'transmission' => 'automatique', 'description' => 'Élégante et performante, la BMW Série 3 allie confort et sportivité.', 'image' => 'sample-bmw-serie-3.png'],
            ['brand' => 0, 'model' => 'X5', 'year' => 2024, 'price' => 150, 'category' => 1, 'color' => 'Noir', 'fuel' => 'hybride', 'seats' => 7, 'transmission' => 'automatique', 'description' => 'SUV de luxe spacieux et technologique.', 'image' => 'sample-bmw-x5.png'],
            ['brand' => 0, 'model' => 'M4', 'year' => 2023, 'price' => 200, 'category' => 2, 'color' => 'Rouge', 'fuel' => 'essence', 'seats' => 4, 'transmission' => 'manuelle', 'description' => 'Coupé sport haute performance.', 'image' => 'sample-bmw-m4.png'],
            
            // Mercedes
            ['brand' => 1, 'model' => 'Classe C', 'year' => 2024, 'price' => 130, 'category' => 0, 'color' => 'Argent', 'fuel' => 'essence', 'seats' => 5, 'transmission' => 'automatique', 'description' => 'Berline de luxe avec un design moderne.', 'image' => 'sample-mercedes-classe-c.png'],
            ['brand' => 1, 'model' => 'GLE', 'year' => 2023, 'price' => 160, 'category' => 1, 'color' => 'Bleu', 'fuel' => 'diesel', 'seats' => 7, 'transmission' => 'automatique', 'description' => 'SUV premium avec toutes les options.', 'image' => 'sample-mercedes-gle.png'],
            ['brand' => 1, 'model' => 'SL', 'year' => 2024, 'price' => 250, 'category' => 3, 'color' => 'Jaune', 'fuel' => 'essence', 'seats' => 2, 'transmission' => 'automatique', 'description' => 'Roadster de luxe iconique.', 'image' => 'sample-mercedes-sl.png'],
            
            // Audi
            ['brand' => 2, 'model' => 'A4', 'year' => 2023, 'price' => 110, 'category' => 0, 'color' => 'Gris', 'fuel' => 'essence', 'seats' => 5, 'transmission' => 'automatique', 'description' => 'Berline compacte premium.', 'image' => 'sample-audi-a4.png'],
            ['brand' => 2, 'model' => 'Q7', 'year' => 2024, 'price' => 140, 'category' => 1, 'color' => 'Blanc', 'fuel' => 'hybride', 'seats' => 7, 'transmission' => 'automatique', 'description' => 'Grand SUV familial de luxe.', 'image' => 'sample-audi-q7.png'],
            ['brand' => 2, 'model' => 'TT', 'year' => 2023, 'price' => 180, 'category' => 2, 'color' => 'Orange', 'fuel' => 'essence', 'seats' => 4, 'transmission' => 'manuelle', 'description' => 'Coupé sport compact et élégant.', 'image' => 'sample-audi-tt.png'],
            
            // Porsche
            ['brand' => 3, 'model' => '911', 'year' => 2024, 'price' => 300, 'category' => 2, 'color' => 'Rouge', 'fuel' => 'essence', 'seats' => 4, 'transmission' => 'manuelle', 'description' => 'Icône sportive légendaire.', 'image' => 'sample-porsche-911.png'],
            ['brand' => 3, 'model' => 'Cayenne', 'year' => 2023, 'price' => 180, 'category' => 1, 'color' => 'Noir', 'fuel' => 'essence', 'seats' => 5, 'transmission' => 'automatique', 'description' => 'SUV sportif de luxe.', 'image' => 'sample-porsche-cayenne.png'],
            
            // Tesla
            ['brand' => 4, 'model' => 'Model S', 'year' => 2024, 'price' => 220, 'category' => 0, 'color' => 'Blanc', 'fuel' => 'electrique', 'seats' => 5, 'transmission' => 'automatique', 'description' => 'Berline électrique haute performance.', 'image' => 'sample-tesla-model-s.png'],
            ['brand' => 4, 'model' => 'Model X', 'year' => 2023, 'price' => 250, 'category' => 1, 'color' => 'Bleu', 'fuel' => 'electrique', 'seats' => 7, 'transmission' => 'automatique', 'description' => 'SUV électrique avec portes Falcon.', 'image' => 'sample-tesla-model-x.png'],
            ['brand' => 4, 'model' => 'Model 3', 'year' => 2024, 'price' => 180, 'category' => 0, 'color' => 'Gris', 'fuel' => 'electrique', 'seats' => 5, 'transmission' => 'automatique', 'description' => 'Berline électrique compacte et moderne.', 'image' => 'sample-tesla-model-3.png'],
            
            // Toyota
            ['brand' => 5, 'model' => 'Camry', 'year' => 2023, 'price' => 80, 'category' => 0, 'color' => 'Argent', 'fuel' => 'hybride', 'seats' => 5, 'transmission' => 'automatique', 'description' => 'Berline fiable et économique.', 'image' => 'sample-toyota-camry.png'],
            ['brand' => 5, 'model' => 'RAV4', 'year' => 2024, 'price' => 90, 'category' => 1, 'color' => 'Blanc', 'fuel' => 'hybride', 'seats' => 5, 'transmission' => 'automatique', 'description' => 'SUV compact hybride.', 'image' => 'sample-toyota-rav4.png'],
            
            // Honda
            ['brand' => 6, 'model' => 'Civic', 'year' => 2023, 'price' => 70, 'category' => 0, 'color' => 'Rouge', 'fuel' => 'essence', 'seats' => 5, 'transmission' => 'manuelle', 'description' => 'Berline compacte sportive.', 'image' => 'sample-honda-civic.png'],
            ['brand' => 6, 'model' => 'CR-V', 'year' => 2024, 'price' => 85, 'category' => 1, 'color' => 'Noir', 'fuel' => 'essence', 'seats' => 5, 'transmission' => 'automatique', 'description' => 'SUV familial fiable.', 'image' => 'sample-honda-cr-v.png'],
            
            // Ford
            ['brand' => 7, 'model' => 'Mustang', 'year' => 2023, 'price' => 120, 'category' => 2, 'color' => 'Jaune', 'fuel' => 'essence', 'seats' => 4, 'transmission' => 'manuelle', 'description' => 'Coupé sport américain iconique.', 'image' => 'sample-ford-mustang.png'],
            ['brand' => 7, 'model' => 'Explorer', 'year' => 2024, 'price' => 100, 'category' => 1, 'color' => 'Gris', 'fuel' => 'essence', 'seats' => 7, 'transmission' => 'automatique', 'description' => 'Grand SUV familial américain.', 'image' => 'sample-ford-explorer.png'],
            
            // Volkswagen
            ['brand' => 8, 'model' => 'Golf', 'year' => 2023, 'price' => 60, 'category' => 5, 'color' => 'Bleu', 'fuel' => 'essence', 'seats' => 5, 'transmission' => 'manuelle', 'description' => 'Citadine compacte et pratique.', 'image' => 'sample-volkswagen-golf.png'],
            ['brand' => 8, 'model' => 'Passat', 'year' => 2024, 'price' => 75, 'category' => 0, 'color' => 'Argent', 'fuel' => 'diesel', 'seats' => 5, 'transmission' => 'automatique', 'description' => 'Berline familiale spacieuse.', 'image' => 'sample-volkswagen-passat.png'],
            
            // Nissan
            ['brand' => 9, 'model' => 'Altima', 'year' => 2023, 'price' => 65, 'category' => 0, 'color' => 'Blanc', 'fuel' => 'essence', 'seats' => 5, 'transmission' => 'automatique', 'description' => 'Berline confortable et économique.', 'image' => 'sample-nissan-altima.png'],
            ['brand' => 9, 'model' => 'Rogue', 'year' => 2024, 'price' => 80, 'category' => 1, 'color' => 'Noir', 'fuel' => 'essence', 'seats' => 5, 'transmission' => 'automatique', 'description' => 'SUV compact moderne.', 'image' => 'sample-nissan-rogue.png'],
        ];

        foreach ($vehicles as $vehicleData) {
            $vehicle = new Vehicule();
            $vehicle->setBrand($brandEntities[$vehicleData['brand']])
                    ->setModel($vehicleData['model'])
                    ->setYear($vehicleData['year'])
                    ->setPricePerDay($vehicleData['price'])
                    ->setCategory($categoryEntities[$vehicleData['category']])
                    ->setColor($vehicleData['color'])
                    ->setFuelType($vehicleData['fuel'])
                    ->setSeats($vehicleData['seats'])
                    ->setTransmission($vehicleData['transmission'])
                    ->setDescription($vehicleData['description'])
                    ->setAvailable(true);
            $manager->persist($vehicle);

            // Add sample images for each vehicle
            $image = new Image();
            $image->setFilename($vehicleData['image'])
                  ->setAlt($vehicleData['model'])
                  ->setIsMain(true)
                  ->setVehicle($vehicle);
            $manager->persist($image);
        }

        $manager->flush();
    }
}
