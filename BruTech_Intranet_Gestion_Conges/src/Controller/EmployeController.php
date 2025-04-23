<?php

namespace App\Controller;

use App\Entity\Conge;
use App\Form\CongeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeController extends AbstractController
{
    #[Route('/employe/dashboard', name: 'app_employe_dashboard')]
    public function dashboard(Request $request, EntityManagerInterface $em): Response
    {
        $conge = new Conge();
        $form = $this->createForm(CongeType::class, $conge);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $conge->setUser($this->getUser());
            $conge->setStatut('en_attente');
            
            $em->persist($conge);
            $em->flush();

            $this->addFlash('success', 'Demande enregistrée !');
            return $this->redirectToRoute('app_employe_dashboard');
        }

        return $this->render('employe/dashboard.html.twig', [
            'form' => $form->createView(),
            'conges' => $this->getUser()->getConges()
        ]);
    }
}