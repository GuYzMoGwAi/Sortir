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

        $ville = $this->getDoctrine()->getRepository(Ville::class);
        $lieux = $this->getDoctrine()->getRepository(Lieu::class);

        if (!$ville && $lieux){
            throw $this->createNotFoundException("Ville ou lieu non trouvé");
        }

        return $this->render('lieu/lieu.html.twig', array(
            'villes' => $ville,
            'lieux' => $lieux,
        ));
    }
}
