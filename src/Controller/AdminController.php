<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Reservation;
use App\Entity\User;
use App\Entity\Vehicule;
use App\Form\VehicleFormType;
use App\Repository\BrandRepository;
use App\Repository\CategoryRepository;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    #[Route('', name: 'app_admin_dashboard')]
    public function dashboard(
        VehiculeRepository $vehiculeRepository,
        ReservationRepository $reservationRepository,
        UserRepository $userRepository
    ): Response {
        $totalVehicles = $vehiculeRepository->count([]);
        $availableVehicles = count($vehiculeRepository->findAvailable());
        $totalReservations = $reservationRepository->count([]);
        $totalUsers = $userRepository->count([]);
        
        $recentReservations = $reservationRepository->findAllWithPagination(1, 5);

        return $this->render('admin/index.html.twig', [
            'totalVehicles' => $totalVehicles,
            'availableVehicles' => $availableVehicles,
            'totalReservations' => $totalReservations,
            'totalUsers' => $totalUsers,
            'recentReservations' => $recentReservations
        ]);
    }

    #[Route('/vehicles', name: 'app_admin_vehicles')]
    public function vehicles(
        Request $request,
        VehiculeRepository $vehiculeRepository,
        PaginatorInterface $paginator
    ): Response {
        $queryBuilder = $vehiculeRepository->createQueryBuilder('v')
            ->leftJoin('v.brand', 'b')
            ->leftJoin('v.category', 'c')
            ->leftJoin('v.images', 'i')
            ->addSelect('i')
            ->orderBy('v.id', 'DESC');

        $vehicles = $paginator->paginate(
            $queryBuilder->getQuery(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/vehicles.html.twig', [
            'vehicles' => $vehicles
        ]);
    }

    #[Route('/vehicles/new', name: 'app_admin_vehicle_new')]
    public function newVehicle(Request $request, EntityManagerInterface $em): Response
    {
        $vehicle = new Vehicule();
        $form = $this->createForm(VehicleFormType::class, $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($vehicle);
            $em->flush();

            $this->addFlash('success', 'Véhicule créé avec succès.');
            return $this->redirectToRoute('app_admin_vehicles');
        }

        return $this->render('admin/vehicle_form.html.twig', [
            'form' => $form->createView(),
            'vehicle' => $vehicle
        ]);
    }

    #[Route('/vehicles/{id}/edit', name: 'app_admin_vehicle_edit')]
    public function editVehicle(Request $request, Vehicule $vehicle, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(VehicleFormType::class, $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Véhicule modifié avec succès.');
            return $this->redirectToRoute('app_admin_vehicles');
        }

        return $this->render('admin/vehicle_form.html.twig', [
            'form' => $form->createView(),
            'vehicle' => $vehicle
        ]);
    }

    #[Route('/vehicles/{id}/delete', name: 'app_admin_vehicle_delete', methods: ['POST'])]
    public function deleteVehicle(Vehicule $vehicle, EntityManagerInterface $em): Response
    {
        $em->remove($vehicle);
        $em->flush();

        $this->addFlash('success', 'Véhicule supprimé avec succès.');
        return $this->redirectToRoute('app_admin_vehicles');
    }

    #[Route('/reservations', name: 'app_admin_reservations')]
    public function reservations(
        Request $request,
        ReservationRepository $reservationRepository,
        PaginatorInterface $paginator
    ): Response {
        $queryBuilder = $reservationRepository->createQueryBuilder('r')
            ->leftJoin('r.utilisateur', 'u')
            ->leftJoin('r.vehicule', 'v')
            ->orderBy('r.createdAt', 'DESC');

        $reservations = $paginator->paginate(
            $queryBuilder->getQuery(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/reservations.html.twig', [
            'reservations' => $reservations
        ]);
    }

    #[Route('/reservations/{id}/status', name: 'app_admin_reservation_status', methods: ['POST'])]
    public function updateReservationStatus(
        Request $request,
        Reservation $reservation,
        EntityManagerInterface $em
    ): Response {
        $status = $request->request->get('status');
        $reservation->setStatut($status);
        $reservation->setUpdatedAt(new \DateTimeImmutable());
        $em->flush();

        $this->addFlash('success', 'Statut de la réservation mis à jour.');
        return $this->redirectToRoute('app_admin_reservations');
    }

    #[Route('/users', name: 'app_admin_users')]
    public function users(
        Request $request,
        UserRepository $userRepository,
        PaginatorInterface $paginator
    ): Response {
        $queryBuilder = $userRepository->createQueryBuilder('u')
            ->orderBy('u.id', 'DESC');

        $users = $paginator->paginate(
            $queryBuilder->getQuery(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/users.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/brands', name: 'app_admin_brands')]
    public function brands(BrandRepository $brandRepository): Response
    {
        $brands = $brandRepository->findAll();
        return $this->render('admin/brands.html.twig', [
            'brands' => $brands
        ]);
    }

    #[Route('/categories', name: 'app_admin_categories')]
    public function categories(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('admin/categories.html.twig', [
            'categories' => $categories
        ]);
    }
}
