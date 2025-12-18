<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Vehicule;
use App\Form\ReservationFormType;
use App\Repository\ReservationRepository;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ReservationController extends AbstractController
{
    #[Route(path: '/mes-reservations', name: 'app_reservations_mes')]
    #[IsGranted('ROLE_USER')]
    public function mesReservations(ReservationRepository $reservationRepository): Response
    {
        $user = $this->getUser();
        $reservations = $reservationRepository->findByUser($user->getId());

        return $this->render('reservation/mes.html.twig', [
            'reservations' => $reservations
        ]);
    }

    #[Route(path: '/reservation/{id}', name: 'app_reservation_create', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function create(Request $request, Vehicule $vehicule, EntityManagerInterface $em): Response
    {
        if (!$vehicule->isAvailable()) {
            $this->addFlash('error', 'Ce véhicule n\'est pas disponible.');
            return $this->redirectToRoute('app_catalogue');
        }

        $reservation = new Reservation();
        $reservation->setVehicule($vehicule);
        $reservation->setUtilisateur($this->getUser());
        $reservation->setCreatedAt(new \DateTimeImmutable());

        $form = $this->createForm(ReservationFormType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Check if vehicle is available for the selected dates
            $reservationRepository = $em->getRepository(Reservation::class);
            if (!$reservationRepository->isVehicleAvailable(
                $vehicule->getId(),
                $reservation->getDebut(),
                $reservation->getFin()
            )) {
                $this->addFlash('error', 'Ce véhicule n\'est pas disponible pour les dates sélectionnées.');
                return $this->render('reservation/create.html.twig', [
                    'form' => $form->createView(),
                    'vehicle' => $vehicule
                ]);
            }

            // Calculate total price
            $totalPrice = $reservation->calculateTotalPrice();
            $reservation->setTotalPrice($totalPrice);

            $em->persist($reservation);
            $em->flush();

            $this->addFlash('success', 'Réservation créée avec succès !');
            return $this->redirectToRoute('app_reservations_mes');
        }

        return $this->render('reservation/create.html.twig', [
            'form' => $form->createView(),
            'vehicle' => $vehicule
        ]);
    }

    #[Route(path: '/reservation/{id}/annuler', name: 'app_reservation_cancel', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function cancel(Reservation $reservation, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        
        // Check if user owns this reservation
        if ($reservation->getUtilisateur() !== $user) {
            throw $this->createAccessDeniedException('Vous ne pouvez pas annuler cette réservation.');
        }

        // Check if reservation can be cancelled
        if ($reservation->getStatut() === 'annule') {
            $this->addFlash('error', 'Cette réservation est déjà annulée.');
        } elseif ($reservation->getStatut() === 'termine') {
            $this->addFlash('error', 'Cette réservation est terminée et ne peut pas être annulée.');
        } else {
            $reservation->setStatut('annule');
            $reservation->setUpdatedAt(new \DateTimeImmutable());
            $em->flush();
            $this->addFlash('success', 'Réservation annulée avec succès.');
        }

        return $this->redirectToRoute('app_reservations_mes');
    }

    #[Route(path: '/reservation/{id}/details', name: 'app_reservation_details', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function details(Reservation $reservation): Response
    {
        $user = $this->getUser();
        
        // Check if user owns this reservation or is admin
        if ($reservation->getUtilisateur() !== $user && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Vous ne pouvez pas voir cette réservation.');
        }

        return $this->render('reservation/details.html.twig', [
            'reservation' => $reservation
        ]);
    }
}
