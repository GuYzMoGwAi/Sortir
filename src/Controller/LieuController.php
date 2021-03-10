<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Form\LieuType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LieuController extends AbstractController
{
    /**
     * @Route("/lieu", name="lieu")
     * @param Request $request
     * @return Response
     */
    public function lieu(Request $request): Response
    {
        $lieu = new Lieu();
        $lieux = $this->getDoctrine()->getRepository(Lieu::class)->findAll();
        $form = $this->createForm(LieuType::class, $lieu);
        $form->handleRequest($request);
//        dd($lieux);

        if (!$lieux && $form) {
            throw $this->createNotFoundException("Ville ou lieu non trouvé");
        }

        return $this->render('lieu/lieu.html.twig', [
            'lieux' => $lieux,
            'lieuForm' => $form->createView(),
        ]);
    }
}
