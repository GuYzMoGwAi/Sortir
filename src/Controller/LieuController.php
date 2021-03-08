<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Entity\Ville;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LieuController extends AbstractController
{
    /**
     * @Route("/lieu", name="lieu")
     */
    public function lieu(): Response
    {

        $lieux = $this->getDoctrine()->getRepository(Lieu::class)->findAll();
//        dd($lieux);

        if (!$lieux){
            throw $this->createNotFoundException("Ville ou lieu non trouvé");
        }

        return $this->render('lieu/lieu.html.twig', [
            'lieux' => $lieux
        ]);
    }
}
