<?php

namespace App\Controller;

use App\Entity\Partenaire;
use App\Repository\PartenaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PartenaireController extends AbstractController
{
    #[Route('/partenaire', name: 'app_partenaire')]
    public function list(PartenaireRepository $partenaireRepository): Response
    {
        $partenaire = $partenaireRepository->findAll();
        return $this->render('partenaire/partenaires.html.twig', [
            'partenaire' => $partenaire ]);
        
    }
}

?>