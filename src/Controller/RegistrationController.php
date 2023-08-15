<?php

namespace App\Controller;

use App\Entity\Account;
use App\Form\ChangementMdpEmailFormType;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new Account();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('page_home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
 /*   #[Route('/change-password-email', name: 'app_change_password_email')]
    public function changementMdpEmail(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangementMdpEmailFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Get the data from the form
            $formData = $form->getData();

            // Update the password if it's changed
            $plainPassword = $formData->getPlainPassword();
            if ($plainPassword) {
                // You can use the password hashing method you have in your User entity
                $hashedPassword = $user->hashPassword($plainPassword); // Replace 'hashPassword' with your actual method name
                $user->setPassword($hashedPassword);
            }

            // Update the email if it's changed
            $email = $formData->getEmail();
            if ($email) {
                $user->setEmail($email);
            }

            $entityManager->flush();

            $this->addFlash('success', 'Votre mot de passe et/ou votre adresse email ont été modifiés avec succès.');

            return $this->redirectToRoute('page_home');
        }

        return $this->render('registration/change_mdp_email.html.twig', [
            'changePasswordEmailForm' => $form->createView(),
        ]);
    }*/
}
