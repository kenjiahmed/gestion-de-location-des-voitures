<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route(path: '/connexion', name: 'app_login')]
    public function login(): Response
    {
        return $this->render('security/login.html.twig');
    }

    #[Route(path: '/deconnexion', name: 'app_logout')]
    public function logout(): void
    {
        // La déconnexion est gérée par le pare-feu
        throw new \LogicException('La déconnexion est gérée par le pare-feu.');
    }
}
