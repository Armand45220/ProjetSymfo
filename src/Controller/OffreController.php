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
    public function offrePerm( PaginatorInterface $paginator, Request $request)
    {
        $query = $this->entityManager->createQuery(
            'SELECT o.date_insert_offre, o.nom_offre, o.desc_offre, o.date_debut_val, o.date_fin_val, o.nb_places_min, o.lien_offre
            FROM App\Entity\Offre o
            WHERE o.type_offre = 1'
        );
        

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
    public function offreLim(PaginatorInterface $paginator, Request $request)
    {
        $query = $this->entityManager->createQuery(
            'SELECT o.date_insert_offre, o.nom_offre, o.desc_offre, o.date_debut_aff, o.date_fin_aff, o.lien_offre
            FROM App\Entity\Offre o
            WHERE o.type_offre = 2 AND o.num_aff != 0
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
    
        return $this->render('offre/offrelim.html.twig', [
            'pagination' => $pagination
        ]);
    }
}
