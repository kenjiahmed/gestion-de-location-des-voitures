<?php

namespace App\Controller;

use App\Entity\Vehicule;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

class CompareController extends AbstractController
{
    private const SESSION_KEY = 'compare_vehicules';
    private const MAX_ITEMS = 3;

    #[Route('/compare', name: 'app_compare_index', methods: ['GET'])]
    public function index(SessionInterface $session, EntityManagerInterface $em): Response
    {
        $ids = $session->get(self::SESSION_KEY, []);
        $vehicules = $ids ? $em->getRepository(Vehicule::class)->findBy(['id' => $ids]) : [];

        // Order vehicles by session order
        $ordered = [];
        foreach ($ids as $id) {
            foreach ($vehicules as $v) {
                if ($v->getId() === (int) $id) {
                    $ordered[] = $v;
                    break;
                }
            }
        }

        return $this->render('compare/index.html.twig', [
            'vehicules' => $ordered,
        ]);
    }

    #[Route('/compare/add', name: 'app_compare_add', methods: ['POST'])]
    public function add(Request $request, SessionInterface $session, EntityManagerInterface $em): JsonResponse
    {
        $id = (int) $request->request->get('id');
        if (!$id) {
            return new JsonResponse(['success' => false, 'message' => 'id manquant'], 400);
        }

        $ids = $session->get(self::SESSION_KEY, []);

        if (in_array($id, $ids, true)) {
            // toggle off
            $ids = array_values(array_diff($ids, [$id]));
            $session->set(self::SESSION_KEY, $ids);
            return new JsonResponse(['success' => true, 'action' => 'removed', 'count' => count($ids)]);
        }

        if (count($ids) >= self::MAX_ITEMS) {
            return new JsonResponse(['success' => false, 'message' => 'Limite atteinte (3)'], 400);
        }

        $vehicule = $em->getRepository(Vehicule::class)->find($id);
        if (!$vehicule) {
            return new JsonResponse(['success' => false, 'message' => 'Véhicule introuvable'], 404);
        }

        $ids[] = $id;
        $session->set(self::SESSION_KEY, $ids);

        return new JsonResponse(['success' => true, 'action' => 'added', 'count' => count($ids)]);
    }

    #[Route('/compare/remove', name: 'app_compare_remove', methods: ['POST'])]
    public function remove(Request $request, SessionInterface $session): JsonResponse
    {
        $id = (int) $request->request->get('id');
        $ids = $session->get(self::SESSION_KEY, []);
        $ids = array_values(array_diff($ids, [$id]));
        $session->set(self::SESSION_KEY, $ids);

        return new JsonResponse(['success' => true, 'count' => count($ids)]);
    }

    #[Route('/compare/clear', name: 'app_compare_clear', methods: ['POST'])]
    public function clear(SessionInterface $session): JsonResponse
    {
        $session->set(self::SESSION_KEY, []);
        return new JsonResponse(['success' => true]);
    }
}
