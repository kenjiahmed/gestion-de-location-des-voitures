<?php

namespace App\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Vehicule;
use App\Entity\Category;
use App\Entity\Brand;

/**
 * Tests unitaires pour l'entité Vehicule
 */
class VehiculeTest extends TestCase
{
    public function testVehiculeCreation(): void
    {
        $vehicule = new Vehicule();
        $vehicule->setModel('Model S');
        $vehicule->setPricePerDay(50000);
        $vehicule->setDescription('Voiture électrique');

        $this->assertSame('Model S', $vehicule->getModel());
        $this->assertSame(50000.0, $vehicule->getPricePerDay());
        $this->assertSame('Voiture électrique', $vehicule->getDescription());
    }

    public function testBrandRelation(): void
    {
        $vehicule = new Vehicule();
        $brand = new Brand();
        $brand->setName('Tesla');

        $vehicule->setBrand($brand);

        $this->assertSame($brand, $vehicule->getBrand());
    }

    public function testCategoryRelation(): void
    {
        $vehicule = new Vehicule();
        $category = new Category();
        $category->setName('Électrique');

        $vehicule->setCategory($category);

        $this->assertSame($category, $vehicule->getCategory());
    }
}

