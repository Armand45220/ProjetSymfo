<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AdminRepository;
use App\Repository\PartenaireRepository;
use App\Repository\FichierOffreRepository;
use App\Repository\FichierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Offre;
use App\Entity\Fichier;
use App\Entity\Partenaire;
use App\Entity\FichierOffre;
use App\Entity\Accueil;
use App\Form\OffrepType;
use App\Form\OffrelType;
use App\Form\ModifLimType;
use App\Form\FoModifType;
use App\Form\ModifPermType;
use App\Form\PartModifType;
use App\Form\HomeType;
use App\Form\FoAjoutType;
use App\Form\PartType;
use App\Form\PartModifImgType;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\PaginatorInterface;



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
    public function createOffrep(Request $request): Response
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
    
            $files = $form->get('fichiers')->getData();
            foreach ($files as $file) {
                $fichier = $this->entityManager->getRepository(Fichier::class)->findOneBy([
                    'cheminFichier' => '.././static/img/' . $file->getClientOriginalName()
                ]);
    
                if (!$fichier) {
                    $fichier = new Fichier();
                    $fichier->setNomFichier($file->getClientOriginalName());
                    $fichier->setCheminFichier('.././static/img/' . $file->getClientOriginalName());
                    $this->entityManager->persist($fichier);
                }
    
                $offreFichier = new FichierOffre();
                $offreFichier->setFichier($fichier);
                $offre->addFichierOffre($offreFichier);
    
                $file->move($this->getParameter('upload_directory'), $fichier->getCheminFichier());
            }
    
            $this->entityManager->persist($offre);
            $this->entityManager->flush();
    
            $this->addFlash('success', 'Offre ajoutée !');
            return $this->redirectToRoute('admin_perm');
        }
    
        return $this->render('admin\offre_form_p.html.twig', [
            'offre' => $offre,
            'form' => $form->createView()
        ]);
    }

    //Controller pour l'ajout des offres limitées

    #[Route("/admin/offre_lim", name: "offre_adm_l")]
    public function createOffrel(Request $request): Response
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
    
            $files = $form->get('fichiers')->getData();
            foreach ($files as $file) {
                $fichier = $this->entityManager->getRepository(Fichier::class)->findOneBy([
                    'cheminFichier' => '.././static/img/' . $file->getClientOriginalName()
                ]);
    
                if (!$fichier) {
                    $fichier = new Fichier();
                    $fichier->setNomFichier($file->getClientOriginalName());
                    $fichier->setCheminFichier('.././static/img/' . $file->getClientOriginalName());
                    $this->entityManager->persist($fichier);
                }
    
                $offreFichier = new FichierOffre();
                $offreFichier->setFichier($fichier);
                $offre->addFichierOffre($offreFichier);
    
                $file->move($this->getParameter('upload_directory'), $fichier->getCheminFichier());
            }
    
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
    //suppression d'une offre
    #[Route('/admin/offre/{id_offre}/supprimer', name: 'supprimer_offre')]
    public function deleteOffer(EntityManagerInterface $em, int $id_offre): Response
    {
        // Récupérer l'offre à supprimer
        $offre = $em->getRepository(Offre::class)->find($id_offre);
    
        // Supprimer les associations FichierOffre
        $fichierOffres = $em->getRepository(FichierOffre::class)->findBy(['offres' => $offre]);
        foreach ($fichierOffres as $fichierOffre) {
            // Supprimer l'association FichierOffre
            $em->remove($fichierOffre);
        }
    
        // Supprimer l'offre
        $em->remove($offre);
        $em->flush();
    
        $this->addFlash('success', 'L\'offre a été supprimée.');
        return $this->redirectToRoute('admin_lim');
    }

    
    // Page admin pour l'affichage des offres limitées dans le backoffice
    #[Route("/admin/offre_aff", name:"admin_lim")]
    public function affOffreL(AdminRepository $adminRepository, Request $request, PaginatorInterface $paginator)
    {
        $offersl = $adminRepository->getOfferslAdmin();

        $pagination = $paginator->paginate(
            $offersl,
            $request->query->getInt('page', 1),
            3
        );
    
        return $this->render('admin/offre_listel.html.twig', [
            'offersl' => $pagination,
        ]);
    }

    // Page admin pour l'affichage des offres permanentes dans le backoffice
    #[Route("/admin/offre_affp", name:"admin_perm")]
    public function affOffreP(AdminRepository $adminRepository, Request $request, PaginatorInterface $paginator)
    {
        $offersp = $adminRepository->getOfferspAdmin();
        
        $pagination = $paginator->paginate(
            $offersp,
            $request->query->getInt('page', 1),
            3
        );
    
        return $this->render('admin/offre_listep.html.twig', [
            'offersp' => $pagination,
        ]);
    }

    //affichage des images liées aux offres dans le backoffice
    #[Route('/admin/{id}/offre_modif/lim/fichiers', name: 'aff_img_admin')]
    
    public function fichiers(Offre $offre, FichierOffreRepository $fichierOffreRepository): Response
    {
        // Récupération des fichiers associés à l'offre
        $fichiersOffres = $fichierOffreRepository->findBy(['offres' => $offre]);

        // Retourne la vue twig en lui passant les données
        return $this->render('admin/images_offre.html.twig', [
            'offre' => $offre,  
            'fichiers' => $fichiersOffres
        ]);
    }

    //Modification des images des offres
    #[Route('/admin/{id}/offre_modif/fichiers/{id_f}/modifier', name: 'modifier_img_admin')]
    public function modifierFichier(Request $request, Offre $offre, $id_f, EntityManagerInterface $entityManager): Response
    {
        $fichierOffre = $entityManager->getRepository(FichierOffre::class)->find($id_f);
        $fichier = $fichierOffre->getFichier();
        
        // Création du formulaire
        $form = $this->createForm(FoModifType::class, $fichierOffre);
    
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
    
            // Récupération du fichier
            $nouveauFichier = $form->get('fichier')->getData();
    
            // Vérification si un fichier avec le même nom existe déjà en base
            $fichierExist = $entityManager->getRepository(Fichier::class)->findOneBy(['nomFichier' => $nouveauFichier->getClientOriginalName()]);
            
            // Si un fichier avec le même nom existe déjà, on met à jour l'entité FichierOffre avec cette entité
            if($fichierExist) {
                $fichierOffre->setFichier($fichierExist);
            } else {
                // Sinon, on crée une nouvelle entité Fichier
                $fichier = new Fichier();
                $fichier->setNomFichier($nouveauFichier->getClientOriginalName());
                $fichier->setCheminFichier('.././static/img/'.'/'.$nouveauFichier->getClientOriginalName());
                $nouveauFichier->move($this->getParameter('upload_directory'), $nouveauFichier->getClientOriginalName());
    
                // Mise à jour de l'entité FichierOffre
                $fichierOffre->setFichier($fichier);
    
                // Enregistrement en base de données
                $entityManager->persist($fichier);
                $entityManager->flush();
            }
    
            // Enregistrement en base de données
            $entityManager->persist($fichierOffre);
            $entityManager->flush();
    
            // Redirection vers la page d'affichage des fichiers de l'offre
            $this->addFlash('success', 'Fichier modifié avec succès');
            return $this->redirectToRoute('aff_img_admin', ['id' => $offre->getId()]);
        }
    
        return $this->render('admin/images_modif_offre.html.twig', [
            'offre' => $offre,
            'form' => $form->createView()
        ]);
    }

    // Ajout d'une image pour une offre sur offre existante
    #[Route('/admin/{id}/offre_modif/fichiers/ajouter', name: 'ajouter_img_admin')]
    public function ajouterFichierOffre(Request $request, int $id, FichierOffreRepository $fichierOffreRepository): Response
    {
        $offre = $this->entityManager->getRepository(Offre::class)->find($id);
    
        if (!$offre) {
            throw $this->createNotFoundException('Offre non trouvée pour id ' . $id);
        }
    
        $fichiersOffres = $fichierOffreRepository->findBy(['offres' => $offre]);
        $nbFichiers = count($fichiersOffres);
        $form = $this->createForm(FoAjoutType::class);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $files = $form->get('fichiers')->getData();
            $nbFichiersAjoutes = count($files);
    
            if ($nbFichiers + $nbFichiersAjoutes > 4) {
                $this->addFlash('error', 'Une offre ne peut contenir que 4 fichiers au maximum');
                return $this->redirectToRoute('aff_img_admin', ['id' => $id]);
            }
    
            foreach ($files as $file) {
                $fichier = $this->entityManager->getRepository(Fichier::class)->findOneBy([
                    'cheminFichier' => '.././static/img/' . $file->getClientOriginalName()
                ]);
    
                if (!$fichier) {
                    $fichier = new Fichier();
                    $fichier->setNomFichier($file->getClientOriginalName());
                    $fichier->setCheminFichier('.././static/img/' . $file->getClientOriginalName());
                    $this->entityManager->persist($fichier);
                }
    
                $offreFichier = new FichierOffre();
                $offreFichier->setFichier($fichier);
                $offre->addFichierOffre($offreFichier);
    
                $file->move($this->getParameter('upload_directory'), $fichier->getCheminFichier());
            }
    
            $this->entityManager->persist($offre);
            $this->entityManager->flush();
    
            $this->addFlash('success', 'Fichier(s) ajouté(s) avec succès');
            return $this->redirectToRoute('aff_img_admin', ['id' => $id]);
        }
    
        return $this->render('admin/ajouter_offre_img.html.twig', [
            'form' => $form->createView(),
            'offre' => $offre,
        ]);
    }
    
// Retirer une image qui est associée à une offre : 
#[Route('/admin/offre_lim/{id}/fichier_offre/{id_f}/supprimer', name: 'supprimer_fichier_offre', requirements: ['id' => '\d+', 'id_f' => '\d+'])]
public function supprimerFichierOffre(Request $request, int $id, int $id_f): Response
{
    $repository = $this->entityManager->getRepository(FichierOffre::class);
    $fichierOffre = $repository->find($id_f);

    if (!$fichierOffre) {
        throw $this->createNotFoundException('Association FichierOffre non trouvée pour id ' . $id_f);
    }

    $offre = $fichierOffre->getOffre();
    $fichierOffres = $offre->getFichierOffre();

    if (count($fichierOffres) < 2) {
        $this->addFlash('error', 'Suppression du fichier impossible : l\'offre doit être associée à un fichier minimum.');
        return $this->redirectToRoute('aff_img_admin', ['id' => $id]);
    }

    $this->entityManager->remove($fichierOffre);
    $this->entityManager->flush();

    $this->addFlash('success', 'Association supprimée avec succès');
    return $this->redirectToRoute('aff_img_admin', ['id' => $id]);
}
//partenaires 
    //ajout partenaires
    #[Route("/admin/partenaire", name:"part_adm")]
    public function ajoutPartenaire(Request $request)
    {
        $partenaire = new Partenaire();
        $fichier = new Fichier();
    
        $form = $this->createForm(PartType::class, $partenaire);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $partenaire = $form->getData();
    
            $existingPartenaire = $this->entityManager->getRepository(Partenaire::class)->findOneBy(['nomPart' => $partenaire->getNomPart()]);
    
            if ($existingPartenaire) {
                $this->addFlash('danger', 'Un partenaire porte déjà le même nom.');
                return $this->redirectToRoute('part_adm');
            }
    
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $existingFile = $this->entityManager->getRepository(Fichier::class)->findOneBy(['nomFichier' => $imageFile->getClientOriginalName()]);
                if ($existingFile) {
                    // Si le fichier existe déjà, on ne peut pas l'associer à un nouveau partenaire
                    $partenaireExist = $this->entityManager->getRepository(Partenaire::class)->findOneBy(['fichierPart' => $existingFile]);
                    if ($partenaireExist) {
                        $this->addFlash('danger', 'Cette image est déjà associée à un partenaire.');
                        return $this->redirectToRoute('part_adm');
                    } else {
                        $partenaire->setFichierPart($existingFile);
                    }
                } else {
                    $newFilename = $imageFile->getClientOriginalName();
                    $imageFile->move($this->getParameter('upload_directory'), $newFilename);
    
                    $fichier->setNomFichier($newFilename);
                    $fichier->setCheminFichier('.././static/img/'.$newFilename);
    
                    $this->entityManager->persist($fichier);
                    $this->entityManager->flush();
    
                    $partenaire->setFichierPart($fichier);
                }
            }
    
            $this->entityManager->persist($partenaire);
            $this->entityManager->flush();
    
            return $this->redirectToRoute('partList');
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
    //suppression du partenaire
    #[Route("/admin/{id}/part_supp", name:"supp_part")]
    public function delete(Partenaire $partenaire, EntityManagerInterface $entityManager)
    {
        $partenaire->setFichierPart(null);
        $entityManager->persist($partenaire);
        $entityManager->flush();
        $entityManager->remove($partenaire);
        $entityManager->flush();

        return $this->redirectToRoute('partList');     
    }
    

    //Affichage des images des partenaires 
    #[Route("/admin/{id}/part_modif/image", name:"img_partenaire")]      
    public function imgPartenaire(int $id, PartenaireRepository $partenaireRepository)
    {
        $partenaire = $partenaireRepository->find($id);
        
        return $this->render('admin/img_part.html.twig', [
            'partenaire' => $partenaire,
        ]);
    }

    //modification de l'image d'un partenaire existant
    #[Route('/admin/partenaire/{id}/edit-image', name: 'partenaire_modif_image')]
    public function editPartenaireImage(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $partenaire = $entityManager->getRepository(Partenaire::class)->find($id);
        $form = $this->createForm(PartModifImgType::class, $partenaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $existingFile = $entityManager->getRepository(Fichier::class)->findOneBy(['nomFichier' => $imageFile->getClientOriginalName()]);
                if ($existingFile) {
                    $partenaire->setFichierPart($existingFile);
                } else {
                    $newFilename = $imageFile->getClientOriginalName();
                    $imageFile->move($this->getParameter('upload_directory'), $newFilename);

                    $fichier = new Fichier();
                    $fichier->setNomFichier($newFilename);
                    $fichier->setCheminFichier('.././static/img/'.$newFilename);

                    $entityManager->persist($fichier);
                    $entityManager->flush();

                    $partenaire->setFichierPart($fichier);
                }
            }
            $entityManager->flush();
            return $this->redirectToRoute('img_partenaire', ['id' => $partenaire->getId()]);
        }

        return $this->render('admin/partenaire_modif_image.html.twig', [
            'partenaire' => $partenaire,
            'form' => $form->createView(),
        ]);
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
