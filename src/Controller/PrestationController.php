<?php

namespace App\Controller;

use App\Entity\Prestation;
use App\Repository\PrestationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrestationController extends AbstractController
{
    #[Route('/prestations', name: 'prestations_list')]
    public function list(PrestationRepository $prestationRepository): Response
    {
        $prestation = $prestationRepository->findAll();

        return $this->render('prestation/list.html.twig', [
            "prestation" => $prestation
        ]);
    }

   /* #[Route('/prestations/details/{id}', name: 'prestations_details')]
    public function details(int $id, PrestationRepository $prestationRepository): Response
    {
        $prestation = $prestationRepository->find($id);

        return $this->render('prestations/details.html.twig', [
            "prestation" => $prestation
        ]);
    }

    #[Route('/prestations/create', name: 'prestations_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $prestations = new Prestations();
        $prestationForm = $this->createForm(PrestationsType::class, $prestations);

        $prestationForm->handleRequest($request);

        if ($prestationForm->isSubmitted() && $prestationForm->isValid()) {
            $entityManager->persist($prestations);
            $entityManager->flush();

            return $this->redirectToRoute('prestations_list');
        }

        return $this->render('prestations/create.html.twig', [
            'prestationForm' => $prestationForm->createView()
        ]);
    }*/
}
