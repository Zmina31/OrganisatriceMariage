<?php

namespace App\Controller;

use App\Entity\Status;
use App\Entity\Temoignage;
use App\Entity\Temoignages;
use App\Form\TemoignageFormType;
use App\Form\TemoignagesFormType;
use App\Repository\StatusRepository;
use App\Repository\TemoignageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TemoignageController extends AbstractController
{
    #[Route('/temoignages', name: 'app_temoignages')]
    public function index(Request $request, EntityManagerInterface $entityManager, StatusRepository $statusRepository, TemoignageRepository $temoignageRepository): Response
    {
        $temoignage = new Temoignage();
        $statusEnAttente = $statusRepository->find(1); // Récupérer le statut "En attente" par son ID

        $temoignage->setStatus($statusEnAttente);
        $formt = $this->createForm(TemoignageFormType::class, $temoignage);
        $formt->handleRequest($request);

        if ($formt->isSubmitted() && $formt->isValid()) {
            $entityManager->persist($temoignage);
            $entityManager->flush();

            return $this->redirectToRoute('app_temoignages');
        }

        $temoignagesValides = $temoignageRepository->findBy(['status' => 2]); // Récupérer les témoignages validés par le statut "Validée"
        return $this->render('temoignage/temoignage.html.twig', [
            'formt' => $formt->createView(),
            'temoignagesValides' => $temoignagesValides,
        ]);
    }

    #[Route('/temoignage/details/{id}', name: 'temoignage_details')]
    public function details(int $id, StatusRepository $statusRepository, TemoignageRepository $temoignageRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $temoignage = $temoignageRepository->find($id);
        $formt = $this->createForm(TemoignageFormType::class, $temoignage);
        $formt->handleRequest($request);

        if ($formt->isSubmitted() && $formt->isValid()) {
            $entityManager->persist($temoignage);
            $entityManager->flush();
        }

        $temoignagesValides = $temoignageRepository->findBy(['status' => $statusRepository->find(2)]);

        return $this->render('admin/index.html.twig', [
            'formt' => $formt->createView(),
            'temoignagesValides' => $temoignagesValides,
        ]);
    }

    #[Route('/temoignage/{id}/valider', name: 'temoignage_valider')]
    public function valider(int $id, EntityManagerInterface $entityManager, StatusRepository $statusRepository, TemoignageRepository $temoignageRepository): Response
    {

        $statusValide = $statusRepository->find(2); // Récupérer le statut "Validée" par son ID

        $temoignage = $temoignageRepository->find($id);
        $temoignage->setStatus($statusValide); // Marquer le témoignage comme validé
        $entityManager->persist($temoignage);
        $entityManager->flush();

        $this->addFlash('success', 'Le témoignage a été validé avec succès.');

        // Rediriger vers la page des témoignages en attente de validation
        return $this->redirectToRoute('app_temoignages');
    }

    #[Route('/temoignage/{id}/rejeter', name: 'temoignage_refuser')]
    public function rejeter(int $id,EntityManagerInterface $entityManager, StatusRepository $statusRepository, TemoignageRepository $temoignageRepository): Response
    {
        $statusRejete = $statusRepository->find(3); // Récupérer le statut "Rejetée" par son ID

        $temoignage = $temoignageRepository->find($id);
        $temoignage->setStatus($statusRejete); // Marquer le témoignage comme rejeté
        $entityManager->persist($temoignage);
        $entityManager->flush();

        $this->addFlash('success', 'Le témoignage a été refusé avec succès.');

        // Rediriger vers la page des témoignages en attente de validation
        return $this->redirectToRoute('app_temoignages');
    }
}

 /*   #[Route('/temoignage/ajouter', name: 'ajouter_temoignage')]
    public function ajouterTemoignageAvecImageDefaut(Request $request, EntityManagerInterface $entityManager, StatusRepository $statusRepository): Response
    {
        $temoignage = new Temoignage();
        $statusEnAttente = $statusRepository->find(1); // Récupérer le statut "En attente" par son ID

        $temoignage->setStatus($statusEnAttente);

        // Définir l'image par défaut à utiliser lorsque l'utilisateur ne télécharge pas d'image
        $imageParDefaut = 'logo1.png'; // Remplacez 'image_par_defaut.jpg' par le nom de votre image par défaut

        $form = $this->createForm(TemoignageFormType::class, $temoignage);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer l'image téléchargée
            $photoFile = $form->get('photo')->getData();

            if ($photoFile) {
                // Générer un nom unique pour l'image
                $newFilename = uniqid().'.'.$photoFile->guessExtension();

                try {
                    // Déplacer l'image téléchargée vers le dossier de stockage des images
                    $photoFile->move(
                        $this->getParameter('dossier_stockage_images'),
                        $newFilename
                    );

                    // Mettre à jour la propriété 'photo' de l'entité Temoignage avec le nom du fichier
                    $temoignage->setPhoto($newFilename);
                } catch (FileException $e) {
                    // Gérer l'erreur si le déplacement de l'image échoue
                    $this->addFlash('error', 'Une erreur s\'est produite lors du téléchargement de l\'image.');
                    return $this->redirectToRoute('ajouter_temoignage');
                }
            } else {
                // Utiliser l'image par défaut si aucune image n'a été téléchargée
                $temoignage->setPhoto($imageParDefaut);
            }

            // Enregistrer l'entité Temoignage en base de données
            $entityManager->persist($temoignage);
            $entityManager->flush();

            // Rediriger ou effectuer d'autres actions en cas de succès
            $this->addFlash('success', 'Le témoignage a été ajouté avec succès.');
            return $this->redirectToRoute('app_temoignages');
        }

        return $this->render('temoignage/temoignage.html.twig', [
            'form' => $form->createView(),
        ]);
    }*/

