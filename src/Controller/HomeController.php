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

    #[Route(path: "/", name: "home")]
    public function HomeOffer(PaginatorInterface $paginator, AccueilRepository $accueilRepository, Request $request)
    {
        $query = $this->entityManager->createQuery(
            'SELECT o.nom_offre, o.desc_offre, o.date_debut_aff, o.date_fin_aff, o.lien_offre
            FROM App\Entity\Offre o
            WHERE o.type_offre = 2
            ORDER BY 
            CASE 
            WHEN o.num_aff IS NOT NULL THEN o.num_aff
            ELSE 99999999 
            END'
            
        );
        
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            3
        );

        $mess = $accueilRepository->findAll();

        return $this->render('accueil/accueil.html.twig', [
            'pagination' => $pagination, 'mess' => $mess]);
    }

}