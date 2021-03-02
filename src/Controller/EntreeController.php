<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

<<<<<<< HEAD:src/Controller/AccueilController.php
class accueilController extends AbstractController
=======
class EntreeController extends AbstractController
>>>>>>> master:src/Controller/EntreeController.php
{
    /**
     * @Route("/", name="entree")
     */
    public function index(): Response
    {
<<<<<<< HEAD:src/Controller/AccueilController.php
        return $this->render('accueil/  index.html.twig');
=======
        return $this->render('accueil/entree.html.twig');
>>>>>>> master:src/Controller/EntreeController.php
    }
}
