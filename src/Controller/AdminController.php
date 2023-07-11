<?php

namespace App\Controller;

use App\Entity\Temoignage;
use App\Repository\ContactRepository;
use App\Repository\TemoignageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(ContactRepository $contactRepository, TemoignageRepository $temoignageRepository): Response
    {
        return $this->render('admin/index.html.twig', [
            'contacts' => $contactRepository->findAll(),
            'temoignages' => $temoignageRepository->findAll(),
        ]);
    }

   /* #[Route('/admin', name: 'admin_temoignages')]
    public function temoignages(TemoignageRepository $temoignageRepository): Response
    {
        $temoignagesNonValides = $temoignageRepository->findBy(['status' => false]);

        return $this->render('admin/temoignages.html.twig', [
            'temoignagesNonValides' => $temoignagesNonValides,

        ]);
    }

    #[Route('/admin/temoignages/{id}/valider', name: 'admin_valider_temoignage')]
    public function validerTemoignage(Temoignage $temoignage, EntityManagerInterface $entityManager): Response
    {
        $temoignage->setStatus(true); // Marquer le témoignage comme validé
        $entityManager->flush();

        $this->addFlash('success', 'Le témoignage a été validé avec succès.');
        // Rediriger vers la page des témoignages en attente de validation
        return $this->redirectToRoute('admin_temoignages');
    }

    #[Route('/admin/temoignages/{id}/supprimer', name: 'admin_supprimer_temoignage')]
    public function supprimerTemoignage(Temoignage $temoignage, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($temoignage);
        $entityManager->flush();

        // Rediriger vers la page des témoignages en attente de validation
        return $this->redirectToRoute('admin_temoignages');
    }*/
}
