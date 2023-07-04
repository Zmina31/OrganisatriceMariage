<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\User;
use App\Form\ContactFormType;
use App\Repository\PrestationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $event = new Contact();
        $form = $this->createForm(ContactFormType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = new User();
            $user->setNom($form->get("nom")->getData());

            $entityManager->persist($event);
            $entityManager->flush();


        }
        return $this->render('contact/contact.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/contact/{id}', name: 'prestation_contact')] /*Pour l'onglet prestation affichage automatique*/
    public function prestation(int $id, PrestationRepository $prestationRepository,Request $request, EntityManagerInterface $entityManager): Response
    {
        $event = new Contact();
        $event->setPrestation($prestationRepository->find($id));
        $user = new User();
        $event->setUser($user);

        $form = $this->createForm(ContactFormType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = new User();
            $user->setNom($form->get("nom")->getData());

            $entityManager->persist($event);
            $entityManager->flush();

        }
        return $this->render('contact/contact.html.twig', [
            'form' => $form,
        ]);
    }
}
