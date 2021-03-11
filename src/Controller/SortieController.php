<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Form\LieuType;
use App\Form\SortieType;
use Doctrine\DBAL\Types\ArrayType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    /**
     * @Route("/sortie/ajouter", name="nouvelle_sortie")
     * @param Request $request
     * @return Response
     */
    public function newSortie(Request $request): Response
    {
        $organisateur = $this->getUser()->getUsername();

        $sortie = new Sortie();
        $form = $this->createForm(SortieType::class, $sortie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //enregistrement BDD
            $entityManager = $this->getDoctrine()->getManager();
            $sortie->setOrganisateur($organisateur);
            $entityManager->persist($sortie);
            $entityManager->flush();
            $this->addFlash('success', "Sortie créée");

            return $this->redirectToRoute('accueil');
        }
        return $this->render('sortie/creerSortie.html.twig',[
            'sortieForm'=> $form->createView()
        ]);
    }

    /**
     * @Route("/modifierSortie/{idSortie}", name="Modifier Sortie")
     * @param  int $idSortie
     * @param Request $request
     * @return Response
     */
    public function editSortie(int $idSortie, Request $request): Response
    {
        $sortie = $this->getDoctrine()->getRepository(Sortie::class)->findBy(["id"=>$idSortie]);
        $form = $this->createForm(SortieType::class, $sortie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //enregistrement BDD
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sortie);
            $entityManager->flush();
            $this->addFlash('success', "Sortie Modifiée");
        }
        return $this->render('sortie/creerSortie.html.twig',[
            'sortieForm'=> $form->createView()
        ]);
    }

}
