<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function accueil(): Response
    {
        return $this->render('accueil/accueil.html.twig', [
            '1' => [
                'nom' => 'Au grand air',
                'date' => '28/06/2021',
                'cloture' => '21/06/2021',
                'inscrits' => 8,
                'places' => 10,
                'etat' => 'En cours',
                'inscrit' => true,
                'organisateur' => 'John Orga',
                'action' => [
                    'inscription' => false,
                    'desister' => true,
                ],
            ],
        ]);
    }
}
