<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Entity\Ville;
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
        $villeRepo = $this->getDoctrine()->getRepository(Ville::class);
        $villes = $villeRepo->findAll();
        $lieuRepo = $this->getDoctrine()->getRepository(Lieu::class);
        $lieux = $lieuRepo->findBy([], ["nom" => "ASC"]);
//        dump($villes);



        return $this->render('accueil/accueil.html.twig', [
            'villes' => $villes,
            'lieux' => $lieux,
            'userCookie' => [
                'nom' => 'John Doe'
            ],
            'sorties' => [
                'sortie1' => [
                    'nom' => 'Au grand air',
                    'date' => '28/06/2021',
                    'cloture' => '21/06/2021 20h30',
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
                'sortie2' => [
                    'nom' => 'À la mer',
                    'date' => '25/06/2021',
                    'cloture' => '18/06/2021 11h20',
                    'inscrits' => 8,
                    'places' => 10,
                    'etat' => 'En cours',
                    'inscrit' => false,
                    'organisateur' => 'John Doe',
                    'action' => [
                        'inscription' => false,
                        'desister' => true,
                    ],
                ],
                'sortie3' => [
                    'nom' => 'Virus sharing',
                    'date' => '28/06/2021',
                    'cloture' => '21/06/2021 16h40',
                    'inscrits' => 8,
                    'places' => 10,
                    'etat' => 'En cours',
                    'inscrit' => true,
                    'organisateur' => 'Imperator Macron',
                    'action' => [
                        'inscription' => false,
                        'desister' => true,
                    ],
                ],
                'sortie4' => [
                    'nom' => 'Tir au chat',
                    'date' => '28/06/2021',
                    'cloture' => '21/06/2021 16h40',
                    'inscrits' => 6,
                    'places' => 8,
                    'etat' => 'En cours',
                    'inscrit' => true,
                    'organisateur' => 'John Doe',
                    'action' => [
                        'inscription' => false,
                        'desister' => true,
                    ],
                ],
            ],
        ]);
    }
}
