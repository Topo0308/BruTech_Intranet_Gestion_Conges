<?php

namespace App\Controller;

use App\Entity\Conge;
use App\Form\CongeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Gestion des demandes de congé
 */
#[Route('/conge')]
class CongeController extends AbstractController
{
    #[Route('/new', name: 'app_conge_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $conge = new Conge();
        $form = $this->createForm(CongeType::class, $conge);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $conge->setUser($this->getUser());
            $em->persist($conge);
            $em->flush();
            
            return $this->redirectToRoute('app_conge_index');
        }
        
        return $this->render('conge/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}