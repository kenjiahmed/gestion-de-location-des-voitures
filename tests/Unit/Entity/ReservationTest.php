<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Reservation;
use App\Entity\Vehicule;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * Tests unitaires pour l'entité Reservation
 */
class ReservationTest extends TestCase
{
    public function testReservationCreation(): void
    {
        $reservation = new Reservation();
        $dateDebut = new \DateTimeImmutable('2026-01-10');
        $dateFin = new \DateTimeImmutable('2026-01-15');

        $reservation->setDebut($dateDebut);
        $reservation->setFin($dateFin);
        $reservation->setStatut('en attente');

        $this->assertSame($dateDebut, $reservation->getDebut());
        $this->assertSame($dateFin, $reservation->getFin());
        $this->assertSame('en attente', $reservation->getStatut());
    }

    public function testReservationRelations(): void
    {
        $reservation = new Reservation();
        $vehicule = new Vehicule();
        $user = new User();

        $reservation->setVehicule($vehicule);
        $reservation->setUtilisateur($user);

        $this->assertSame($vehicule, $reservation->getVehicule());
        $this->assertSame($user, $reservation->getUtilisateur());
    }
}

