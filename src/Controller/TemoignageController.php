<?php

namespace App\Controller;

use App\Entity\Temoignage;
use App\Entity\Temoignages;
use App\Form\TemoignageFormType;
use App\Form\TemoignagesFormType;
use App\Repository\TemoignageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class TemoignageController extends AbstractController
{
    #[Route('/temoignages', name: 'app_temoignages')]
    public function index(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $temoignage = new Temoignage();
        $formt = $this->createForm(TemoignageFormType::class, $temoignage);
        $formt->handleRequest($request);

        if ($formt->isSubmitted() && $formt->isValid()) {
            // Vous pouvez gérer la validation de l'administrateur ici
            $temoignage->setStatus(false); // Par défaut, le témoignage est marqué comme non validé

            $entityManager->persist($temoignage);
            $entityManager->flush();

            $email = (new Email())
                ->from('minazekri69@yahoo.fr')
                ->to('minoucheiako@gmail.com')
                ->subject('Nouveau témoignage à valider')
                ->text('Un nouveau témoignage a été soumis et attend votre validation.')
                ->html('<p>Un nouveau témoignage a été soumis et attend votre validation.</p><p>Voici les détails du témoignage :</p><p>Nom : ' . $temoignage->getNom() . '</p><p>Contenu : ' . $temoignage->getContenu() . '</p>');

            $mailer->send($email);

            // Envoyer une notification à l'administrateur par e-mail
            // Utilisez le composant de messagerie de Symfony pour envoyer l'e-mail
            $this->addFlash('success', 'Votre témoignage a été soumis avec succès. Il sera validé par l\'administrateur avant d\'être affiché.');

            // Rediriger l'utilisateur vers une page de remerciement ou une page de confirmation

            return $this->redirectToRoute('app_temoignages');
        }

        return $this->render('temoignage/temoignage.html.twig', [
            'formt' => $formt->createView(),
        ]);
    }
    #[Route('/temoignage/details/{id}', name: 'temoignage_details')] /*Pour l'onglet prestation affichage automatique*/
    public function details(int $id, TemoignageRepository $temoignageRepository, Request $request, EntityManagerInterface $entityManager): Response
    {

        $temoignage = $temoignageRepository->find($id);
        $formt = $this->createForm(TemoignageFormType::class, $temoignage);
        $formt->handleRequest($request);

        if ($formt->isSubmitted() && $formt->isValid()) {

            $entityManager->persist($temoignage);
            $entityManager->flush();

        }
        return $this->render('temoignage/temoignage.html.twig', [
            'formt' => $formt->createView(),
        ]);
    }
}
