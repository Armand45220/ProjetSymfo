<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FichierController extends AbstractController
{
    #[Route('/fichier', name: 'app_fichier')]
    public function index(): Response
    {
        return $this->render('fichier/index.html.twig', [
            'controller_name' => 'FichierController',
        ]);
    }
}
