<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FichierOffreController extends AbstractController
{
    #[Route('/fichier/offre', name: 'app_fichier_offre')]
    public function index(): Response
    {
        return $this->render('fichier_offre/index.html.twig', [
            'controller_name' => 'FichierOffreController',
        ]);
    }
}
