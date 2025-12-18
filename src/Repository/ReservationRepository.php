<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservation>
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function save(Reservation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Reservation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Reservation[] Returns reservations for a specific user
     */
    public function findByUser($userId): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.utilisateur = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('r.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Reservation[] Returns reservations for a specific vehicle
     */
    public function findByVehicle($vehicleId): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.vehicule = :vehicleId')
            ->setParameter('vehicleId', $vehicleId)
            ->orderBy('r.debut', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Check if a vehicle is available for a specific date range
     */
    public function isVehicleAvailable($vehicleId, $startDate, $endDate): bool
    {
        $result = $this->createQueryBuilder('r')
            ->andWhere('r.vehicule = :vehicleId')
            ->setParameter('vehicleId', $vehicleId)
            ->andWhere('r.statut != :cancelled')
            ->setParameter('cancelled', 'annule')
            ->andWhere('(r.debut <= :endDate AND r.fin >= :startDate)')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->getQuery()
            ->getResult();

        return empty($result);
    }

    /**
     * @return Reservation[] Returns all reservations with pagination
     */
    public function findAllWithPagination($page = 1, $limit = 10): array
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.createdAt', 'DESC')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
