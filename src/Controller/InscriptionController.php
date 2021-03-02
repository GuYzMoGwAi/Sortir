<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscription(Request $request )
    {
        // 1) Construire le formulaire
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) gérer l'envoie ( que sur le POST )
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 4) Sauvegarde l'utilisateur
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // todo faire tout autre traitement - comme l'envoie de mail.
            // todo peut-être définir un message de réussite "flash" pour l'utilisateur

            return $this->redirectToRoute('inscription');
        }

        return $this->render(
            'utilisateurs/inscription.html.twig',
            array('form' => $form->createView())
        );
    }
}
