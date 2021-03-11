<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\SortieUtilisateur;
use App\Entity\Utilisateur;
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
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $utilisateursSorties = $this->getDoctrine()->getRepository(SortieUtilisateur::class)->findBy(["utilisateur_id"=>$user->getId()]);
        //$userSorties = $this->getDoctrine()->getRepository(SortieUtilisateur::class)->findAll();
        $sorties = $this->getDoctrine()->getRepository(Sortie::class)->findAll();
        $villes = $this->getDoctrine()->getRepository(Ville::class)->findAll();
        $lieux = $this->getDoctrine()->getRepository(Lieu::class)->findBy([], ["nom" => "ASC"]);

        return $this->render('accueil/accueil.html.twig', [
            'villes' => $villes,
            'lieux' => $lieux,
            'userCookie' => $user,
            'sorties' => $sorties,
            //'userSorties'=> $userSorties,
            'utilisateursSorties'=> $utilisateursSorties
        ]);
    }
}
