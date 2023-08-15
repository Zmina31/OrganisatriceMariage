<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'page_home')]
    public function home()
    {
        return $this->render('page/home.html.twig', [
            'images' => [
                'img/posters/4.jpg',
                'img/posters/14.jpg',
                'img/posters/18.jpg',
            ],
            'welcomeMessage' => "Bienvenue au paradis des émotions",
            'description' => "Nous sommes une agence de Wedding planner sur la région Lyonnaise et intervenons sur l'Isère, la Drôme et la Loire également.

        Nous accompagnons les couples dans l’organisation et la coordination de leur mariage en proposant différentes formules pour répondre à toutes les demandes.

        Notre point fort, personnaliser le mariage à votre image pour des souvenirs uniques.

        En espérant que vous trouverez votre chemin ici.",
        ]);
    }
}
