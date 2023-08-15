<?php

namespace App\Controller;

use App\Entity\Temoignage;
use App\Form\ChangementMdpEmailFormType;
use App\Repository\ContactRepository;
use App\Repository\TemoignageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    /*#[Security('is_granted("ROLE_ADMIN")')] */// Restreindre l'accès aux administratrices
    public function index(ContactRepository $contactRepository, TemoignageRepository $temoignageRepository): Response
    {
        return $this->render('admin/index.html.twig', [
            'contacts' => $contactRepository->findAll(),
            'temoignages' => $temoignageRepository->findAll(),
        ]);
    }
}
 /*   #[Route('/admin/change-password-email', name: 'app_change_password_email')]
    public function changePasswordEmail(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangementMdpEmailFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Get the form data
            $formData = $form->getData();




// Update the password if it's changed
            $plainPassword = $formData['plainPassword'];
            if ($plainPassword) {
                $hashedPassword = $userPasswordHasher->hashPassword($user, $plainPassword);
                $user->setPassword($hashedPassword);
            }

            // Update the email if it's changed
            $email = $formData['email'];
            if ($email) {
                $user->setEmail($email);
            }

            $entityManager->flush();

            $this->addFlash('success', 'Votre mot de passe et/ou votre adresse email ont été modifiés avec succès.');

            return $this->redirectToRoute('page_home');
        }

        return $this->render('admin/change_mdp_email.html.twig', [
            'changePasswordEmailForm' => $form->createView(),
        ]);
    }*/
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

