<?php

namespace App\Controller;

use App\Repository\MariageRepository;
use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GalerieController extends AbstractController
{
    #[Route('/galeries', name: 'app_galeries')]
    public function photos(PhotoRepository $photoRepository, EntityManagerInterface $entityManager, MariageRepository $mariageRepository): Response
    {
        $mariages = $mariageRepository->findAll();


        return $this->render('galerie/index.html.twig', [
            'mariages' => $mariages,

        ]);
    }

    #[Route('/galeries/{id}', name: 'app_galeries_filtrees')]
    public function photosFiltrees(
        Request                $request,
                               $id,
        PhotoRepository        $photoRepository,
        EntityManagerInterface $entityManager,
        MariageRepository      $mariageRepository
    ): Response
    {
        $mariages = $mariageRepository->findAll();
        $mariage = $mariageRepository->find($id);

        if (!$mariage) {
            throw $this->createNotFoundException('Mariage non trouvé.');
        }

        return $this->render('galerie/index.html.twig', [
            'mariages' => $mariages,
            'mariage' => $mariage,
        ]);
    }
}
