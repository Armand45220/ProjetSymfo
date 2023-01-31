<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessController extends AbstractController
{
    #[Route('/mess', name: 'app_mess')]
    public function index(): Response
    {
        return $this->render('mess/index.html.twig', [
            'controller_name' => 'MessController',
        ]);
    }
}
