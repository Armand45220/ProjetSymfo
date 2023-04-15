<?php

namespace App\Controller;

use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;


class OffreController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    // Offre permanentes
    #[Route(path: "/offre", name: "offre")]
    public function offrePerm( PaginatorInterface $paginator, Request $request, OffreRepository $offreRepository)
    {
        $query = $offreRepository->affOffresPerm();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            3
        );
    
        return $this->render('offre/offreperm.html.twig', [
            'pagination' => $pagination
        ]);
    }
    // Offres limitées
    #[Route(path: "offre/offreslimitées", name: "offresLim")]
    public function offreLim(PaginatorInterface $paginator, Request $request, OffreRepository $offreRepository)
    {
        $query = $offreRepository->affOffresLim();
        
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            3
        );
    
        return $this->render('offre/offrelim.html.twig', [
            'pagination' => $pagination
        ]);
    }
}
