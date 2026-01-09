<?php

namespace App\Tests\Integration\Repository;

use App\Entity\Vehicule;
use App\Entity\Brand;
use App\Entity\Category;
use App\Repository\VehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Tests d'intégration pour VehiculeRepository
 */
class VehiculeRepositoryTest extends KernelTestCase
{
    private ?VehiculeRepository $repository = null;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->repository = self::getContainer()->get(VehiculeRepository::class);
    }

    public function testFindAll(): void
    {
        $vehicules = $this->repository->findAll();
        $this->assertIsArray($vehicules);
    }

    public function testCount(): void
    {
        $count = $this->repository->count([]);
        $this->assertIsInt($count);
        $this->assertGreaterThanOrEqual(0, $count);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->repository = null;
    }
}

