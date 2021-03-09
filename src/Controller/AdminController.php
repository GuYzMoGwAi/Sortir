<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $userRepo = $this->getDoctrine()->getRepository(Utilisateur::class);
        $users = $userRepo->findAll();
        $sortieRepo = $this->getDoctrine()->getRepository(Sortie::class);
        $sorties = $sortieRepo->findAll();
        $lieuRepo = $this->getDoctrine()->getRepository(Lieu::class);
        $lieux = $lieuRepo->findAll();
        $siteRepo = $this->getDoctrine()->getRepository(Site::class);
        $sites = $siteRepo->findAll();
        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etats = $etatRepo->findAll();
        return $this->render('admin/admin.html.twig', [
            'utilisateurs' => $users,
            'sorties' => $sorties,
            'lieux' => $lieux,
            'sites' => $sites,
            'etats' => $etats,
        ]);
    }
}
