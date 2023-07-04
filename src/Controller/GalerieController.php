<?php

namespace App\Controller;

use App\Repository\MariageRepository;
use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GalerieController extends AbstractController
{
    #[Route('/galeries', name: 'app_galeries')]
    public function photos(PhotoRepository $photoRepository, EntityManagerInterface $entityManager, MariageRepository $mariageRepository): Response
    {
        $mariages = $mariageRepository->findAll();
        $photosByMariage = [];

        foreach ($mariages as $mariage) {
            $photo = $photoRepository->findBy(['mariage' => $mariage]);
            $photosByMariage[$mariage->getId()] = $photo;
        }

        return $this->render('galerie/index.html.twig', [
            'mariages' => $mariages,
            'photosByMariage' => $photosByMariage,
        ]);
    }
}
