<?php

namespace App\Controller;

use App\Entity\Site;
use App\Form\SiteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    /**
     * @Route("/site", name="site")
     * @param Request $request
     * @return Response
     */

    public function site(Request $request): Response
    {
        $site = new Site();
        $sites = $this->getDoctrine()->getRepository(Site::class)->findAll();
        $form = $this->createForm(SiteType::class, $site);
        $form->handleRequest($request);

        if (!$sites && $form) {
            throw $this->createNotFoundException("Le site n'a pas été trouvé");
        }

        return $this->render('site/site.html.twig', [
            'sites' => $sites,
            'site' => $form->createView(),

        ]);
    }

    /**
     * @Route("/site/ajouter", name="add_site")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function siteAdd(Request $request, EntityManagerInterface $em): Response
    {
        $site = new Site();
        $form = $this->createForm(SiteType::class, $site);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($site);
            $em->flush();

            $this->addFlash('success', 'Le site à bien été ajouté');
            return $this->redirectToRoute('site');
        }

        return $this->render('site/siteAdd.html.twig', [
            'siteForm' => $form->createView(),
            'h1' => 'Ajouter le site',
            'button' => 'Ajouter',
        ]);
    }
<<<<<<< HEAD
=======

    /**
     * @Route("/site/modifier/{id}", name="update_site")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Site $site
     * @return Response
     */
    public function siteUpdate(Request $request, EntityManagerInterface $em, Site $site): Response
    {
        $form = $this->createForm(SiteType::class, $site);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($site);
            $em->flush();

            $this->$this->addFlash('success', 'Le site a bien été modifié');
            return $this->redirectToRoute('site', [
                'id' => $site->getId(),
            ]);
        }
        return $this->render('site/siteAdd.html.twig', [
            'siteForm' => $form->createView(),
            'h1' => 'Modifier le site',
            'button' => 'Modifier',
        ]);
    }

    /**
     * @Route("/site/supprimer/{id}", name="delete_site")
     * @param EntityManagerInterface $em
     * @param $id
     * @return Response
     */
    public function siteDelete(EntityManagerInterface $em, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $site = $em->getRepository('App:Site')->find($id);

        if (!$site) {
            throw $this->createNotFoundException('L\'id n\'a pas été trouvée' . $id);
        }
        $em->remove($site);
        $em->flush();
        $this->addFlash('success', 'Le site a bien été supprimé');

        return $this->redirectToRoute('site');
    }
>>>>>>> master
}
