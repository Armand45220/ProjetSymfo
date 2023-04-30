<?php

namespace App\Controller;

use App\Entity\Action;
use App\Entity\APropos;
use App\Entity\Membre;
use App\Form\ActionType;
use App\Form\MembreType;
use App\Form\AProposType;
use App\Form\ActionModifType;
use App\Form\MembreModifType;
use App\Form\AProposModifType;
use App\Repository\ActionRepository;
use App\Repository\AProposRepository;
use App\Repository\ContactRepository;
use App\Repository\FichierRepository;
use App\Repository\MembreRepository;
use App\Repository\NotificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AdminRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
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
    
    public function createOffre(Request $request, MailerInterface $mailer, ContactRepository $contactRepository, NotificationRepository $notificationRepository) : Response
    {
        $offre = new Offre();
        $form = $this->createForm(OffrepType::class, $offre);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // Si le 'num_aff' n'existe pas déjà, enregistrer la nouvelle offre
            $this->entityManager->persist($offre);
            $this->entityManager->flush();

            //Initialisation des tableaux contacts et notifications
            $contacts = [];
            $notifications = [];

            //Récupère les emails des personnes dans la table contact
            foreach ($contactRepository->findAll() as $contact) {
                if ($contact->getInscriptionCont() == 1) {
                    $contacts[] = $contact->getMailCont();
                }
            }

            //Récupère les emails des personnes dans la table notification
            foreach ($notificationRepository->findAll() as $notification) {
                //Récupère un email de la table contact
                $contactFound = $contactRepository->findByEmailAndInscription($notification->getEmailNotif(),1);

                //Vérifie si le contact n'existe pas pour envoyer l'email
                if ($contactFound === null) {
                    $notifications[] = $notification->getEmailNotif();
                }
            }

            // Envoi de l'email des personnes dans la table contact
            $email = (new TemplatedEmail())
                ->from('cuisine.saintvincentsenlis@gmail.com')
                ->to(...$contacts)
                ->subject('Une nouvelle offre disponible')
                ->htmlTemplate('email/send_offer.html.twig')
                ->context([
                    'offre' => $offre
                ]);
            /*Envoie d'un email*/
            $mailer->send($email);

            //Envoi de l'email des personnes dans la table notification
            $email2 = (new TemplatedEmail())
                ->from('cuisine.saintvincentsenlis@gmail.com')
                ->to(...$notifications)
                ->subject('Une nouvelle offre disponible')
                ->htmlTemplate('email/send_offer.html.twig')
                ->context([
                    'offre' => $offre
                ]);
            /*Envoie d'un email*/
            $mailer->send($email2);

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
    #[Route("/admin/partenaire/add", name:"part_adm")]
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

            return $this->redirectToRoute('partList');
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
        $fichier = $partenaire->getFichier();
        $entityManager->remove($fichier);
        $entityManager->flush();
        return $this->redirectToRoute('partList');
    }

    //a Propos de nous
    //ajout a propos de nous
    #[Route("/admin/aPropos/add", name:"APropos_admin")]
    public function addAPropos(Request $request)
    {
        $propos = new APropos();
        $form = $this->createForm(AProposType::class, $propos);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $propos
               ->setDescReglements($form->get('descReglements')->getData())
               ->setEmail($form->get('email')->getData())
               ;
                $this->entityManager->persist($propos);
                $this->entityManager->flush();

                return $this->redirectToRoute('aProposAffiche');
            }

            return $this->render('admin/aProposAjouter.html.twig', [
                'form' => $form->createView(),
            ]);
    }
    // Affichage de A propos de nous
    #[Route("/admin/afficheAPropos", name:"aProposAffiche")]
    public function aProposAffiche(AProposRepository $AProposRepository): Response
    {
        return $this->render('admin/aPropos-liste.html.twig', [
                'infos_aPropos' => $AProposRepository->findAll()]
        );
    }

    //Modification de a propos de nous
    #[Route("/admin/{id}/aPropos_modif", name:"modif_aPropos")]
    public function editAPropos(Request $request, EntityManagerInterface $em, int $id)
    {
        $propos = $em->getRepository(APropos::class)->find($id);
        $oldEmail = $propos->getEmail();
        $oldDescReglements = $propos->getDescReglements();

        $form = $this->createForm(AProposModifType::class, $propos);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('email')->getData() === null) {
                $propos->setEmail($oldEmail);
            }

            if ($form->get('descReglements')->getData() === null) {
                $propos->setDescReglements($oldDescReglements);
            }

            $em->persist($propos);
            $em->flush();

            return $this->redirectToRoute('aProposAffiche');
        }

        return $this->render('admin/proposModif.html.twig', [
            'form' => $form->createView(),
            'propos' => $propos,
        ]);
    }

    //suppression de a propos de nous
    #[Route("/admin/{id}/aPropos_supp", name:"supp_aPropos")]
    public function deleteAPropos(APropos $propos, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($propos);
        $entityManager->flush();
        return $this->redirectToRoute('aProposAffiche');
    }

    //Membre
    //ajout Membre
    #[Route("/admin/membre/add", name:"membre_admin")]
    public function addMembre(Request $request)
    {
        $membre = new Membre();
        $fichier = new Fichier();

        $form = $this->createForm(MembreType::class, $membre);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $propos = $form->getData();

            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->getClientOriginalExtension();
                $imageFile->move($this->getParameter('upload_directory'), $newFilename);

                $fichier->setNomFichier($imageFile->getClientOriginalName());
                $fichier->setCheminFichier('..\..\static\img'.$newFilename);

                $this->entityManager->persist($fichier);
                $this->entityManager->flush();

                $propos->setFichier($fichier);
            }

            $this->entityManager->persist($membre);
            $this->entityManager->flush();

            return $this->redirectToRoute('membreAffiche');
        }

        return $this->render('admin/membreAjouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    // Affichage de membre
    #[Route("/admin/afficheMembre", name:"membreAffiche")]
    public function membreAffiche(MembreRepository $membreRepository): Response
    {
        $membre = $membreRepository->findAll();
        return $this->render('admin/membres-liste.html.twig', [
            'membres' => $membre ]);

    }
    //Modification de membre
    #[Route("/admin/{id}/membre_modif", name:"modif_membre")]
    public function editMembre(Request $request, EntityManagerInterface $em, int $id)
    {
        $membre = $em->getRepository(Membre::class)->find($id);
        $oldNomMembre = $membre->getNomMembre();
        $oldDescMembre = $membre->getDescMembre();
        $form = $this->createForm(MembreModifType::class, $membre);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('nom_membre')->getData() === null) {
                $membre->setNomMembre($oldNomMembre);
            }

            if ($form->get('desc_membre')->getData() === null) {
                $membre->setDescMembre($oldDescMembre);
            }

            $em->persist($membre);
            $em->flush();

            return $this->redirectToRoute('membreAffiche');
        }

        return $this->render('admin/membreModifier.html.twig', [
            'form' => $form->createView(),
            'membre' => $membre,
        ]);
    }

    //suppression de membre
    #[Route("/admin/{id}/membre_supp", name:"supp_membre")]
    public function deleteMembre(Membre $membre, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($membre);
        $entityManager->flush();

        // Supprime le fichier associé
        $fichier = $membre->getFichier();
        $entityManager->remove($fichier);
        $entityManager->flush();
        return $this->redirectToRoute('membreAffiche');
    }


    //Action
    //ajout action
    #[Route("/admin/action/add", name:"action_adm")]
    public function addAction(Request $request)
    {
        $action = new Action();
        $form = $this->createForm(ActionType::class, $action);

        $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
            $action
               ->setDescAct($form->get('desc_act')->getData())
               ;
                $this->entityManager->persist($action);
                $this->entityManager->flush();

                return $this->redirectToRoute('actionAffiche');
            }
            return $this->render('admin/actionAjouter.html.twig', [
                'form' => $form->createView(),
            ]);
    }

    // Affichage de Action
    #[Route("/admin/afficheAction", name:"actionAffiche")]
    public function actionAffiche(ActionRepository $actionRepository): Response
    {
        $action = $actionRepository->findAll();
        return $this->render('admin/actions_liste.html.twig', [
            'infos_actions' => $action ]);

    }
    //Modification de l'action
    #[Route("/admin/{id}/action_modif", name:"modif_action")]
    public function editAction(Request $request, EntityManagerInterface $em, int $id)
    {
        $action = $em->getRepository(Action::class)->find($id);
        $oldNomAction = $action->getNomAct();
        $oldDescAction = $action->getDescAct();

        $form = $this->createForm(ActionModifType::class, $action);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('nom_act')->getData() === null) {
                $action->setNomAct($oldNomAction);
            }

            if ($form->get('desc_act')->getData() === null) {
                $action->setDescAct($oldDescAction);
            }

            $em->persist($action);
            $em->flush();

            return $this->redirectToRoute('actionAffiche');
        }

        return $this->render('admin/actionModifier.html.twig', [
            'form' => $form->createView(),
            'infos_action' => $action,
        ]);
    }

    //suppression de l'action
    #[Route("/admin/{id}/action_supp", name:"supp_action")]
    public function deleteAction(Action $action, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($action);
        $entityManager->flush();

        return $this->redirectToRoute('actionAffiche');
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
