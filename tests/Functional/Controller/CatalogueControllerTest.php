<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Tests fonctionnels pour CatalogueController
 */
class CatalogueControllerTest extends WebTestCase
{
    public function testCataloguePageIsSuccessful(): void
    {
        $client = static::createClient();
        $client->request('GET', '/catalogue');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('html', 'Catalogue');
    }

    public function testCataloguePageDisplaysVehicles(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/catalogue');

        $this->assertResponseIsSuccessful();
        // Vérifie que la page contient le mot "catalogue" ou "véhicule"
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Catalogue"), html:contains("véhicule")')->count());
    }
}

