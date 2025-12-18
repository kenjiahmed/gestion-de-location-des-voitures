<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VehicleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // This fixture is now handled by AppFixtures
        // Keeping this file for potential future specific vehicle fixtures
        $manager->flush();
    }
}
