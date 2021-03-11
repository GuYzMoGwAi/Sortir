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
        $lieux = $this->getDoctrine()->getRepository(Lieu::class)->findAll();
        $lieu = new Lieu();
        $form = $this->createForm(LieuType::class, $lieu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($lieu);
            $em->flush();

            $this->addFlash('success', 'Le lieu a bien été ajouté');
            return $this->redirectToRoute('lieu');
        }


        return $this->render('lieu/lieuAdd.html.twig', [
            'lieux' => $lieux,
            'lieuForm' => $form->createView(),
            'h1' => 'Ajouter le lieu',
        ]);
    }

    /**
     * @Route("/modifier/{id}", name="update_lieu")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param $lieu
     * @return Response
     */
    public function lieuUpdate(Request $request, EntityManagerInterface $em, Lieu $lieu): Response
    {
        $lieux = $this->getDoctrine()->getRepository(Lieu::class)->findAll();
        $form = $this->createForm(LieuType::class, $lieu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($lieu);
            $em->flush();

            $this->addFlash('success', 'Le lieu a bien été modifié');
            return $this->redirectToRoute('lieu', [
                'id' => $lieu->getId(),
            ]);
        }

        return $this->render('lieu/lieuAdd.html.twig', [
            'lieux' => $lieux,
            'lieuForm' =>$form->createView(),
            'h1' => 'Modifier le lieu',
        ]);
    }

    /**
     * @Route("/lieu/supprimer/{id}", name="delete_lieu")
     * @param EntityManagerInterface $em
     * @param $id
     * @return Response
     */
    public function lieuDelete(EntityManagerInterface $em, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $lieu = $em->getRepository('App:Lieu')->find($id);

        if (!$lieu) {
            throw $this->createNotFoundException('L\'id n\'a pas été trouvée' . $id);
        }
        $em->remove($lieu);
        $em->flush();
        $this->addFlash('success', 'Le lieu a bien été supprimé');

        return $this->redirectToRoute('lieu');
    }
}
