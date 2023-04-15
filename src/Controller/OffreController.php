<?php

namespace App\Controller;

use App\Repository\OffreRepository;
use App\Entity\Offre;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;


class OffreController extends AbstractController
{
    private $offreRepository;

    public function __construct(OffreRepository $offreRepository)
    {
        
        $this->offreRepository = $offreRepository;
    }

    // Offre permanentes
    #[Route(path: "/offres-permanentes", name: "offre")]
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
    #[Route(path: "offre/offres-limitées", name: "offresLim")]
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

    //actualisation des offres limitées
    #[Route("/actualiser-offres-lim", name:"actualiser_lim")]
    public function actualiserOffresL()
    {
        $this->offreRepository->actualiserOffresLim();

        return $this->redirectToRoute('offresLim');
    }

    //actualisation des offres limitées
    #[Route("/actualiser-offres-perm", name:"actualiser_perm")]
    public function actualiserOffresP()
    {
        $this->offreRepository->actualiserOffresPerm();

        return $this->redirectToRoute('offre');
    }

}
