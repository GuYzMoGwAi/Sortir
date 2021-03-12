<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Entity\Utilisateur;
use App\Form\SortieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $organisateur = $this->getUser();
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
        return $this->render('sortie/creerSortie.html.twig', [
            'sortieForm' => $form->createView(),
            'h1' => 'Créer une sortie',
            'button' => ' Ajouter',
        ]);
    }

    /**
     * @Route("/modifierSortie/{id}", name="modifier_sortie")
     * @param Request $request
     * @param Sortie $sortie
     * @return Response
     */
    public function editSortie(Request $request, Sortie $sortie): Response
    {
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //enregistrement BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($sortie);
            $em->flush();
            $this->addFlash('success', "Sortie Modifiée");

            return $this->redirectToRoute('accueil', [
                'id' => $sortie->getId(),
            ]);
        }
        return $this->render('sortie/creerSortie.html.twig', [
            'sortieForm' => $form->createView(),
            'h1' => 'Modifier la sortie',
            'button' => ' Modifier',
        ]);
    }

    /**
     * @route("/sortie/supprimer/{id}", name="delete_sortie")
     * @param $id
     * @return Response
     */
    public function sortieDelete($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $sortie = $em->getRepository('App:Sortie')->find($id);
//        dd($sortie);

        if (!$sortie) {
            $this->addFlash('error', "La suppression a foiré");
            return $this->redirectToRoute('accueil');
        }

        $em->remove($sortie);
        $em->flush();
        $this->addFlash('success', 'La sortie a bien été supprimé');

        return $this->redirectToRoute('accueil');
    }

    /**
     * Route("/sortie/supprimer/{id}", name="sortie_supprime")
     * @param $id
     * @return Response
     */
    public function supprimeSortie($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $sortieRepo = $this->getDoctrine()->getRepository(Sortie::class);
        $sortie = $sortieRepo->find($id);
//        dd($sortie);

        if (!$sortie) {
            $this->addFlash('error', "L'id n'a pas été trouvé");
            return $this->redirectToRoute('accueil');
        }

        $em->remove($sortie);
        $em->flush();
        $this->addFlash('success', 'La sortie a bien été supprimé');

        return $this->redirectToRoute('accueil');
    }

    /**
     * @Route ("/sortie/inscritoi/{id}/user/{user_id}", name="inscrit_toi")
     * @param $id
     * @param $user_id
     * @return Response
     */
    public function inscription($id, $user_id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $sortie = $this->getDoctrine()->getRepository(Sortie::class)->find($id);
        $user = $this->getDoctrine()->getRepository(Utilisateur::class)->find($user_id);

        $sortie->addParticipant($user);
//        $user->addSorty($sortie);
//
//        $em->persist($user);
        $em->persist($sortie);
        $em->flush();
        $this->addFlash('success', 'Vous êtes bien inscrit');

        return $this->redirectToRoute('accueil');
    }

}
