<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AdminRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Entity\Offre;
use App\Entity\Fichier;
use App\Entity\Partenaire;
use App\Entity\Accueil;
use App\Form\OffrepType;
use App\Form\OffreModifType;
use App\Form\PartModifType;
use App\Form\HomeType;
use App\Form\PartType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\PartenaireRepository;



class AdminController extends AbstractController 
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/backoff.html.twig');
    }
    //CONTROLLERS BACKOFFICE OFFRE
    #[Route("/admin/offre", name:"offre_adm")]
    
    public function createOffre(Request $request) : Response
    {
        $offre = new Offre();
        $form = $this->createForm(OffrepType::class, $offre);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // Si le 'num_aff' n'existe pas déjà, enregistrer la nouvelle offre
            $this->entityManager->persist($offre);
            $this->entityManager->flush();  

            return $this->redirectToRoute('admin_lim');
        }

        return $this->render('admin\offre_form.html.twig', [
            'offre' => $offre,
            'form' => $form->createView()
        ]);
    }
    // Page admin pour la modif des offres
    #[Route("/admin/{id}/offre_modif", name:"modif_offre")]
    public function editOffer(Request $request, EntityManagerInterface $em, int $id)
    {
        $offer = $em->getRepository(Offre::class)->find($id);

        $form = $this->createForm(OffreModifType::class, $offer);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($offer);
            $em->flush();

            return $this->redirectToRoute('admin_lim');
        }

        return $this->render('admin/offremodif.html.twig', [
            'form' => $form->createView(),
        ]);
        return $this->render('Admin/offremodif.html.twig', [
            'offer' => $offer,
        ]);
    }

    #[Route('/admin/{id}/offre_supprimer', name: 'supprimer_offre')]
    public function deleteOffer(EntityManagerInterface $em, int $id): Response
    {
        $offer = $em->getRepository(Offre::class)->find($id);

        if (!$offer) {
            throw $this->createNotFoundException('Offre non trouvée');
        }

        $em->remove($offer);
        $em->flush();

        return $this->redirectToRoute('admin_lim');
    }

    
    // Page admin pour l'affichage des offres limitées dans le backoffice
    #[Route("/admin/offre_aff", name:"admin_lim")]
    
    public function affOffreL(AdminRepository $adminRepository)
    {
        $offersl = $adminRepository->getOfferslAdmin();

        return $this->render('admin/offre_listel.html.twig', [
            'offersl' => $offersl,
        ]);

    }

    // Page admin pour l'affichage des offres permanentes dans le backoffice
    #[Route("/admin/offre_affp", name:"admin_perm")]
    
    public function affOffreP(AdminRepository $adminRepository)
    {
        $offersp = $adminRepository->getOfferspAdmin();

        return $this->render('admin/offre_listep.html.twig', [
            'offersp' => $offersp,
        ]);
    }



    //partenaires 
        //ajout partenaires
        #[Route("/admin/partenaire", name:"part_adm")]
    
        public function addPartenaire(Request $request)
        {
            $partenaire = new Partenaire();
            $fichier = new Fichier();
        
            $form = $this->createForm(PartType::class, $partenaire);
        
            $form->handleRequest($request);
        
            if ($form->isSubmitted() && $form->isValid()) {
                $partenaire = $form->getData();
        
                $imageFile = $form->get('image')->getData();
                if ($imageFile) {
                    $newFilename = uniqid().'.'.$imageFile->getClientOriginalExtension();
                    $imageFile->move($this->getParameter('upload_directory'), $newFilename);
        
                    $fichier->setNomFichier($imageFile->getClientOriginalName());
                    $fichier->setCheminFichier('C:\Users\decor\OneDrive\Bureau\ProjetSymfo\public\static\img'.$newFilename);
        
                    $this->entityManager->persist($fichier);
                    $this->entityManager->flush();
        
                    $partenaire->setFichier($fichier);
                }
        
                $this->entityManager->persist($partenaire);
                $this->entityManager->flush();
        
                return $this->redirectToRoute('app_admin');
            }
        
            return $this->render('admin/part_form.html.twig', [
                'form' => $form->createView(),
            ]);
        }
        // Affichage des partenaires
        #[Route("/admin/listePartenaires", name:"partList")]
        public function listPart(PartenaireRepository $partenaireRepository): Response
        {
            $partenaire = $partenaireRepository->findAll();
            return $this->render('admin/part_liste.html.twig', [
                'partenaire' => $partenaire ]);
            
        }
        //Modification des partenaires
        #[Route("/admin/{id}/part_modif", name:"modif_part")]
        public function editPart(Request $request, EntityManagerInterface $em, int $id)
        {
            $part = $em->getRepository(Partenaire::class)->find($id);
    
            $form = $this->createForm(PartModifType::class, $part);
    
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($part);
                $em->flush();
    
                return $this->redirectToRoute('app_admin');
            }
    
            return $this->render('admin/partmodif.html.twig', [
                'form' => $form->createView(),
            ]);
            return $this->render('admin/partmodif.html.twig', [
                'part' => $part,
            ]);
        }

        //suppression des partenaires
        #[Route("/admin/{id}/part_supp", name:"supp_part")]
        public function delete(Partenaire $partenaire, EntityManagerInterface $entityManager)
        {
            $entityManager->remove($partenaire);
            $entityManager->flush();
    
            // Supprime le fichier associé
            $fichier = $partenaire->getFichier();
            $entityManager->remove($fichier);
            $entityManager->flush();
            return $this->redirectToRoute('partList');
        }
    
        //Page d'accueil
        #[Route("/admin/accueil", name:"home_adm")]
    
        public function createMess(Request $request) : Response
        {
            $existingMess = $this->entityManager->getRepository(Accueil::class)->findOneBy([]);
        
            if ($existingMess === null) {
                $mess = new Accueil();
            } else {
                $mess = $existingMess;
            }
        
            $form = $this->createForm(HomeType::class, $mess);
        
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
        

                $this->entityManager->persist($mess);
                $this->entityManager->flush();  
        
                return $this->redirectToRoute('app_admin');
            }
        
            return $this->render('admin\home_form.html.twig', [
                'mess' => $mess,
                'form' => $form->createView()
            ]);
        }
}

?>
