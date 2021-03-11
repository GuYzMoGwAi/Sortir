<?php

namespace App\Controller;

use App\Entity\Site;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    /**
     * @Route("/site", name="site")
     */

    public function site(): Response
    {

        $sites = $this->getDoctrine()->getRepository(Site::class)->findAll();

        if (!$sites) {
            throw $this->createNotFoundException("Le site n'a pas été trouvé");
        }

        return $this->render('site/site.html.twig', [
            'sites' => $sites,

        ]);
    }

//    /**
//     * @Route("/site/ajouter", name="add_site")
//     * @return Response
//     */
//    public function siteAdd(): Response
//    {
//        return $this->render('site/site.html.twig');
//    }
//
//    /**
//     * @Route('/site/modifier/{id}", name="update_site")
//     * @return Response
//     */
//    public function siteUpdate(): Response
//    {
//        return $this->render('site/site.html.twig');
//    }
//
//    /**
//     * @Route("/site/supprimer/{id}", name="delete_site")
//     * @return Response
//     */
//    public function siteDelete(): Response
//    {
//        return $this->render('site/site.html.twig');
//    }
}
