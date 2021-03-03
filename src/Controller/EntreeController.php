<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntreeController extends AbstractController
{
    /**
     * @Route("/", name="entree")
     */
    public function entree(): Response
    {
	return $this->render('accueil/entree.html.twig');
    }

}