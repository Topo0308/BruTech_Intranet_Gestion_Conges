<?php

namespace App\Controller;

use App\Entity\Conge;
use App\Form\TraitementDemandeType;
use App\Repository\CongeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManagerController extends AbstractController
{
    #[Route('/manager', name: 'app_manager_dashboard')]
    public function dashboard(CongeRepository $congeRepo): Response
    {
        return $this->render('manager/dashboard.html.twig', [
            'demandesEnAttente' => $congeRepo->findBy(['statut' => 'en_attente'])
        ]);
    }

    #[Route('/manager/traitement/{id}', name: 'app_manager_traitement')]
    public function traiterDemande(Conge $demande, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(TraitementDemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Demande traitée avec succès');
            return $this->redirectToRoute('app_manager_dashboard');
        }

        return $this->render('manager/traitement.html.twig', [
            'demande' => $demande,
            'form' => $form->createView()
        ]);
    }
}
