<?php

namespace App\Controller;

use App\Repository\AccueilRepository;
use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class HomeController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route(path: "/accueil", name: "home")]
    public function offreAccueil(PaginatorInterface $paginator, OffreRepository $offreRepository, AccueilRepository $accueilRepository, Request $request)
    {
        // Utilisation de la fonction modifiée "affOffresLim" pour obtenir la liste des offres
        $query = $offreRepository->affOffresLimAccueil();
    
        // Utilisation de la pagination pour limiter le nombre d'offres affichées par page
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            3
        );
    
        // Récupération de la liste des messages de la page d'accueil
        $mess = $accueilRepository->findAll();
    
        // Affichage de la page d'accueil avec les offres et les messages de la page d'accueil
        return $this->render('accueil/accueil.html.twig', [
            'pagination' => $pagination,
            'mess' => $mess
        ]);
    }

}