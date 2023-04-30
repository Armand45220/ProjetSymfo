<?php

namespace App\Controller;
use App\Form\NotificationType;

use App\Repository\AccueilRepository;
use App\Repository\OffreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Notification;
use Symfony\Component\Form\FormFactoryInterface;


class NotificationController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager, private RequestStack $requestStack)
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws NonUniqueResultException
     */
    #[Route('/inscription-newsletter', name: 'app_newsletter_registration')]
    public function subscribe(PaginatorInterface $paginator, AccueilRepository $accueilRepository,OffreRepository $offreRepository, Request $request, MailerInterface $mailer):Response{
        $this->newsletterForm($mailer, $offreRepository);

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

    /**
     * @throws TransportExceptionInterface|NonUniqueResultException
     */
    public function newsletterForm(MailerInterface $mailer, OffreRepository $offreRepository):Response
    {
        // Créer une instance du formulaire
        $newletter =  new Notification() ;
        $offreRecent = $offreRepository->findMostRecentOffer(count($offreRepository->findAll()));

        $notif =  $this->createForm(NotificationType::class, null, [
            'action' => $this->generateUrl('app_newsletter_registration'),
        ]);
        // Valider et traiter les données soumises
        $notif->handleRequest($this->requestStack->getCurrentRequest());
        if ($notif->isSubmitted() && $notif->isValid()) {
            $data = $notif->getData();
            $newletter->setEmailNotif($data['email_notif']);
            $newletter->setInscriptionNotif(1);

            $this->entityManager->persist($newletter);
            $this->entityManager->flush();

            $email = (new TemplatedEmail())
                ->from('cuisine.saintvincentsenlis@gmail.com')
                ->to($newletter->getEmailNotif())
                ->subject('Votre newsletter')
                ->htmlTemplate('email/send_newsletter.html.twig')
                ->context([
                    'user' => $newletter->getEmailNotif(),
                    'offre' => $offreRecent
                ]);
                /*Envoie d'un email*/
                $mailer->send($email);

        }

        // Afficher le formulaire
        return $this->render('includes/_newsletter_registration_form.html.twig', [
            'notification' => $notif->createView(),
        ]);
    }
}

