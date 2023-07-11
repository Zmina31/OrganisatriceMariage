<?php

namespace App\Controller;

use App\Entity\Prestation;
use App\Form\PrestationFormType;
use App\Repository\PrestationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrestationController extends AbstractController
{
    #[Route('/prestations', name: 'prestations_list')]
    public function list(PrestationRepository $prestationRepository): Response
    {
        $prestations = $prestationRepository->findAll();

        return $this->render('prestation/list.html.twig', [
            "prestations" => $prestations
        ]);
    }

    #[Route('/prestations/details/{id}', name: 'prestations_details')]
    public function details(int $id, PrestationRepository $prestationRepository): Response
    {
        $prestation = $prestationRepository->find($id);

        return $this->render('prestation/details.html.twig', [
            "prestation" => $prestation
        ]);
    }

    #[Route('/prestations/create', name: 'prestations_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $prestations = new Prestation();
        $prestationForm = $this->createForm(PrestationFormType::class, $prestations);

        $prestationForm->handleRequest($request);

        if ($prestationForm->isSubmitted() && $prestationForm->isValid()) {
            $entityManager->persist($prestations);
            $entityManager->flush();

            return $this->redirectToRoute('prestations_list');
        }

        return $this->render('prestation/create.html.twig', [
            'prestationForm' => $prestationForm->createView()
        ]);
    }
}
