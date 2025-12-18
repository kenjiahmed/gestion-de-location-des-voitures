<?php
namespace App\Controller;

use App\Entity\Vehicule;
use App\Repository\BrandRepository;
use App\Repository\CategoryRepository;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogueController extends AbstractController
{
    #[Route('/catalogue', name: 'app_catalogue')]
    public function index(
        Request $request,
        VehiculeRepository $vehiculeRepository,
        BrandRepository $brandRepository,
        CategoryRepository $categoryRepository,
        PaginatorInterface $paginator
    ): Response {
        $search = $request->query->get('search', '');
        $brandId = $request->query->get('brand');
        $categoryId = $request->query->get('category');
        $minPrice = $request->query->get('min_price');
        $maxPrice = $request->query->get('max_price');

        $queryBuilder = $vehiculeRepository->createQueryBuilder('v')
            ->leftJoin('v.brand', 'b')
            ->leftJoin('v.category', 'c')
            ->leftJoin('v.images', 'i')
            ->addSelect('i')
            ->andWhere('v.available = :available')
            ->setParameter('available', true);

        if ($search) {
            $queryBuilder->andWhere('v.model LIKE :search OR b.name LIKE :search OR c.name LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        if ($brandId) {
            $queryBuilder->andWhere('v.brand = :brandId')
                ->setParameter('brandId', $brandId);
        }

        if ($categoryId) {
            $queryBuilder->andWhere('v.category = :categoryId')
                ->setParameter('categoryId', $categoryId);
        }

        if ($minPrice) {
            $queryBuilder->andWhere('v.pricePerDay >= :minPrice')
                ->setParameter('minPrice', $minPrice);
        }

        if ($maxPrice) {
            $queryBuilder->andWhere('v.pricePerDay <= :maxPrice')
                ->setParameter('maxPrice', $maxPrice);
        }

        $queryBuilder->orderBy('v.brand', 'ASC')
            ->addOrderBy('v.model', 'ASC');

        $vehicles = $paginator->paginate(
            $queryBuilder->getQuery(),
            $request->query->getInt('page', 1),
            12
        );

        $brands = $brandRepository->findAll();
        $categories = $categoryRepository->findAll();

        return $this->render('catalogue/index.html.twig', [
            'vehicles' => $vehicles,
            'brands' => $brands,
            'categories' => $categories,
            'search' => $search,
            'selectedBrand' => $brandId,
            'selectedCategory' => $categoryId,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
        ]);
    }

    #[Route('/vehicule/{id}', name: 'app_vehicle_details')]
    public function details(Vehicule $vehicule): Response
    {
        return $this->render('catalogue/details.html.twig', [
            'vehicle' => $vehicule
        ]);
    }
}
