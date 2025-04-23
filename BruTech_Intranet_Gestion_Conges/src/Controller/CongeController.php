<?php

namespace App\Controller;

use App\Entity\Conge;
use App\Form\CongeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CongeController extends AbstractController
{
    #[Route('/conge/new', name: 'conge_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Vérifie si l'utilisateur est connecté
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('login');
        }
    
        // Créer un nouvel objet Conge
        $conge = new Conge();
        
        // Créer le formulaire basé sur le type CongeType
        $form = $this->createForm(CongeType::class, $conge);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // L'utilisateur associé au congé
            $conge->setUser($user);
            $conge->setStatut(Conge::STATUT_EN_ATTENTE);
    
            // Enregistrer le congé en base de données
            $entityManager->persist($conge);
            $entityManager->flush();
    
            // Ajouter un message flash de succès
            $this->addFlash('success', 'Demande de congé envoyée avec succès !');
            
            // Rediriger vers la page des congés
            return $this->redirectToRoute('mes_conges');
        }
    
        // Rendre le formulaire dans la vue
        return $this->render('conge/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
    

