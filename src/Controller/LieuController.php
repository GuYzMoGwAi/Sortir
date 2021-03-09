<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Form\LieuType;
use Doctrine\ORM\EntityManagerInterface;
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
            'lieu' => $form->createView(),
        ]);
    }

//    /**
//     * @Route("/lieu/{id}", name="detail_lieu", requirements={"id":"\d+"})
//     * @return Response
//     */
//    public function lieuDetail($id): Response
//    {
//        $repo = $this->getDoctrine()->getRepository(Lieu::class);
//        $lieu = $repo->find($id);
//
//        return $this->render('lieu/lieuDetail.html.twig',compact('lieu'));
//    }

    /**
     * @Route("/lieu/ajouter", name="add_lieu")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function lieuAdd(Request $request, EntityManagerInterface $em): Response
    {
        $lieu = new Lieu();
        $form = $this->createForm(LieuType::class);

        return $this->render('lieu/lieuAdd.html.twig', [
            'lieuForm' => $form->createView(),
        ]);
    }

//    /**
//     * @Route('/lieu/modifier/{id}", name="update_lieu")
//     * @return Response
//     */
//    public function lieuUpdate(): Response
//    {
//        return $this->render('lieu/lieu.html.twig');
//    }
//
//    /**
//     * @Route("/lieu/supprimer/{id}", name="delete_lieu")
//     * @return Response
//     */
//    public function lieuDelete(): Response
//    {
//        return $this->render('lieu/lieu.html.twig');
//    }
}
