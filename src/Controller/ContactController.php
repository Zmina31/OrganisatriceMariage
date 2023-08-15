<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Prestation;
use App\Entity\User;
use App\Form\ContactFormType;
use App\Repository\ContactRepository;
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
      /*
       * Mis en commentaire car à chaque demande de contact ça m'affiche une nouvelle prestation ( à voir avec seb)
        $event = new Contact();
        $event->setStatus(0);
        $user = new User();
        $event->setUser($user);*/
      /*  $prestation = new Prestation();
        $event->setPrestation($prestation); */
        $event = new Contact(); // Déclaration de la variable $event
        $form = $this->createForm(ContactFormType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($event);
            $entityManager->flush();

        }
        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/contact/{id}', name: 'prestation_contact')] /*Pour l'onglet prestation affichage automatique*/
    public function prestation(int $id, PrestationRepository $prestationRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $event = new Contact();
       /* $event->setStatus(0);*/
        $event->setPrestation($prestationRepository->find($id));
        $user = new User();     //creer user
        $event->setUser($user); //ds le new contact 41 tu me mets l'user

        $form = $this->createForm(ContactFormType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($event);
            $entityManager->flush();

        }
        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/contact/details/{id}', name: 'contact_detail')] /*Pour l'onglet prestation affichage automatique*/
    public function details(int $id, ContactRepository $contactRepository, Request $request, EntityManagerInterface $entityManager): Response
    {

        $event = $contactRepository->find($id);
        $form = $this->createForm(ContactFormType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($event);
            $entityManager->flush();

        }
        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
