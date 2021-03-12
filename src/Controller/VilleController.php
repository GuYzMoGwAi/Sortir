<?php

namespace App\Controller;

use App\Entity\Ville;
use App\Form\VilleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VilleController extends AbstractController
{
    /**
     * @Route("/ville", name="ville")
     * @param Request $request
     * @return Response
     */
    public function ville(Request $request): Response
    {
        $villes = $this->getDoctrine()->getRepository(Ville::class)->findAll();

        return $this->render('ville/ville.html.twig', [
            'villes' => $villes,
        ]);
    }

    /**
     * @Route("/ville/ajouter", name="add_ville")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function villeAdd(Request $request, EntityManagerInterface $em): Response
    {
        $ville = new Ville();
        $form = $this->createForm(VilleType::class, $ville);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($ville);
            $em->flush();

            $this->addFlash('success', 'La ville a bien été ajouté');
            return $this->redirectToRoute('ville');
        }


        return $this->render('ville/villeAdd.html.twig', [
            'villeForm' => $form->createView(),
            'h1' => 'Ajouter la ville',
            'button' => 'Ajouter',
        ]);
    }

    /**
     * @Route("/ville/modifier/{id}", name="update_ville")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Ville $ville
     * @return Response
     */
    public function villeUpdate(Request $request, EntityManagerInterface $em, Ville $ville): Response
    {
        $form = $this->createForm(VilleType::class, $ville);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($ville);
            $em->flush();

            $this->addFlash('success', 'La ville a bien été modifié');
            return $this->redirectToRoute('ville', [
                'id' => $ville->getId(),
            ]);
        }
        return $this->render('ville/villeAdd.html.twig', [
            'villeForm' => $form->createView(),
            'h1' => 'Modifier la ville',
            'button' => 'Modifier',
        ]);
    }

    /**
     * @Route("/ville/supprimer/{id}", name="delete_ville")
     * @param EntityManagerInterface $em
     * @param $id
     * @return Response
     */
    public function villeDelete(EntityManagerInterface $em, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $ville = $em->getRepository('App:Ville')->find($id);

        if (!$ville) {
            throw $this->createNotFoundException('L\'id n\'a pas été trouvée' . $id);
        }
        $em->remove($ville);
        $em->flush();
        $this->addFlash('success', 'La ville a bien été supprimé');

        return $this->redirectToRoute('ville');
    }
}
