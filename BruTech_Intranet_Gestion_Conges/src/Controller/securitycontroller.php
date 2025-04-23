<?php

// src/Controller/SecurityController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function login(): Response
    {
        return $this->render('security/login.html.twig');
    }

    #[Route('/logout', name: 'app_logout')]  // Utilisation de app_logout comme nom de route pour la déconnexion
    public function logout(): void
    {
        // Symfony gère automatiquement la déconnexion ici, donc cette méthode reste vide
        // La redirection sera gérée automatiquement par le firewall
    }
}

