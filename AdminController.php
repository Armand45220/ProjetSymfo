<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AdminRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Offre;
use App\Entity\Fichier;
use App\Entity\Partenaire;
use App\Entity\Accueil;
use App\Form\OffrepType;
use App\Form\OffrelType;
use App\Form\ModifLimType;
use App\Form\ModifPermType;
use App\Form\PartModifType;
use App\Form\HomeType;
use App\Form\PartType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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

    #[Route("/admin/offre_menu", name:"offre_menu")]

    public function offerMenu() : Response{
        return $this->render('admin/offre_menu.html.twig');
    }

    //Ajout d'offres permanentes

    #[Route("/admin/offre_perm", name:"offre_adm_p")]
    
    public function createOffrep(Request $request) : Response
    {
        $offre = new Offre();
        $form = $this->createForm(OffrepType::class, $offre);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifie que la date de fin des offres permanentes soit toujours supérieure à la date de début
            $dateDebutValidite = $offre->getDateDebutVal();
            $dateFinValidite = $offre->getDateFinVal();
    
            if ($dateFinValidite <= $dateDebutValidite) {
                $this->addFlash('error', 'La date de fin doit être supérieure à la date de début.');
                return $this->redirectToRoute('offre_adm_p');
            }

            // Remplir automatiquement la date d'insertion
            $offre->setDateInsertOffre(new \DateTime('now'));

            $this->entityManager->persist($offre);
            $this->entityManager->flush();  

            $this->addFlash('success', 'Offre ajoutée !');  
            return $this->redirectToRoute('admin_perm');
        }

        return $this->render('admin\offre_form_p.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
    }

    //Controller pour l'ajout des offres limitées

    #[Route("/admin/offre_lim", name:"offre_adm_l")]
    
    public function createOffrel(Request $request) : Response
    {
        $offre = new Offre();
        $form = $this->createForm(OffrelType::class, $offre);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // Vérifie que la date de fin des offres permanentes soit toujours supérieure à la date de début

            $dateDebutAffichage = $offre->getDateDebutAff();
            $dateFinAffichage = $offre->getDateFinAff();
    
            if ($dateFinAffichage <= $dateDebutAffichage) {
                $this->addFlash('error', 'La date de fin doit être supérieure à la date de début.');
                return $this->redirectToRoute('offre_adm_l');
            }
            
            // Remplir automatiquement la date d'insertion
            $offre->setDateInsertOffre(new \DateTime('now'));

            $this->entityManager->persist($offre);
            $this->entityManager->flush();  

            $this->addFlash('success', 'Offre ajoutée !');  
            return $this->redirectToRoute('admin_lim');
        }

        return $this->render('admin\offre_form_l.html.twig', [
            'offre' => $offre,
            'form' => $form->createView()
        ]);
    }

    // Page admin pour la modif des offres limitées
    #[Route("/admin/{id}/offre_modif/lim", name:"modif_offre_lim")]
    public function editOfferLim(Request $request, EntityManagerInterface $em, int $id)
    {
        $offer = $em->getRepository(Offre::class)->find($id);

        $form = $this->createForm(ModifLimType::class, $offer);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $dateDebutAffichage = $offer->getDateDebutAff();
            $dateFinAffichage = $offer->getDateFinAff();

            if ($dateFinAffichage <= $dateDebutAffichage) {
                $this->addFlash('error', 'La date de fin doit être supérieure à la date de début.');
                return $this->render('admin/offremodiflim.html.twig', [
                    'form' => $form->createView(),
                    'offer' => $offer,
                ]);
            }
            
            $em->persist($offer);
            $em->flush();
            
            $this->addFlash('success', 'Offre modifiée !');
            return $this->redirectToRoute('admin_lim');
        }

        return $this->render('admin/offremodiflim.html.twig', [
            'form' => $form->createView(),
            'offer' => $offer,
        ]);
    }

    // Page admin pour la modif des offres permanentes
    #[Route("/admin/{id}/offre_modif/perm", name:"modif_offre_perm")]
    public function editOfferPerm(Request $request, EntityManagerInterface $em, int $id)
    {
        $offer = $em->getRepository(Offre::class)->find($id);

        $form = $this->createForm(ModifPermType::class, $offer);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $dateDebutValidite = $offer->getDateDebutVal();
            $dateFinValidite = $offer->getDateFinVal();

            if ($dateFinValidite <= $dateDebutValidite) {
                $this->addFlash('error', 'La date de fin doit être supérieure à la date de début.');
                return $this->render('admin/offremodifperm.html.twig', [
                    'form' => $form->createView(),
                    'offer' => $offer,
                ]);
            }
            
            $em->persist($offer);
            $em->flush();
            
            $this->addFlash('success', 'Offre modifiée !');
            return $this->redirectToRoute('admin_perm');
        }

        return $this->render('admin/offremodifperm.html.twig', [
            'form' => $form->createView(),
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


        $this->addFlash('success', 'Offre supprimée !');
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
        $fichier = $partenaire->getFichierPart();
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
