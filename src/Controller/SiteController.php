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
}
