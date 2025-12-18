<?php

namespace App\Repository;

use App\Entity\Vehicule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vehicule>
 */
class VehiculeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicule::class);
    }

    public function save(Vehicule $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Vehicule $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Vehicule[] Returns an array of available vehicles
     */
    public function findAvailable(): array
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.available = :available')
            ->setParameter('available', true)
            ->orderBy('v.brand', 'ASC')
            ->addOrderBy('v.model', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Vehicule[] Returns vehicles by brand
     */
    public function findByBrand($brandId): array
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.brand = :brandId')
            ->setParameter('brandId', $brandId)
            ->andWhere('v.available = :available')
            ->setParameter('available', true)
            ->orderBy('v.model', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Vehicule[] Returns vehicles by category
     */
    public function findByCategory($categoryId): array
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.category = :categoryId')
            ->setParameter('categoryId', $categoryId)
            ->andWhere('v.available = :available')
            ->setParameter('available', true)
            ->orderBy('v.brand', 'ASC')
            ->addOrderBy('v.model', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Vehicule[] Returns vehicles by price range
     */
    public function findByPriceRange($minPrice, $maxPrice): array
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.pricePerDay >= :minPrice')
            ->setParameter('minPrice', $minPrice)
            ->andWhere('v.pricePerDay <= :maxPrice')
            ->setParameter('maxPrice', $maxPrice)
            ->andWhere('v.available = :available')
            ->setParameter('available', true)
            ->orderBy('v.pricePerDay', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Search vehicles by text
     */
    public function searchByText(string $search): array
    {
        return $this->createQueryBuilder('v')
            ->leftJoin('v.brand', 'b')
            ->leftJoin('v.category', 'c')
            ->andWhere('v.model LIKE :search OR b.name LIKE :search OR c.name LIKE :search')
            ->setParameter('search', '%' . $search . '%')
            ->andWhere('v.available = :available')
            ->setParameter('available', true)
            ->orderBy('v.brand', 'ASC')
            ->addOrderBy('v.model', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
