<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\MessUtilisateur;
use App\Form\FormType;
use App\Repository\ContactRepository;
use App\Repository\MessUtilisateurRepository;
use App\Repository\OffreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3Validator;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $entityManager, OffreRepository $offreRepository, MailerInterface $mailer, Recaptcha3Validator $recaptcha3Validator): Response
    {
        $contact = new Contact();
        $message = new MessUtilisateur();
        $offreRecent = $offreRepository->findMostRecentOffer(count($offreRepository->findAll()));

        $form = $this->createForm(FormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $score = $recaptcha3Validator->getLastResponse()->getScore();
            if ($score > 0.5) {
                $contact
                    ->setNomCont($form->get('nom_cont')->getData())
                    ->setPrenomCont($form->get('prenom_cont')->getData())
                    ->setMailCont($form->get('email_cont')->getData())
                    ->setInscriptionCont($form->get('inscription_cont')->getData())
                ;
                $message->setLibelleMess($form->get('libelle_mess')->getData());
                $entityManager->persist($contact);
                $entityManager->flush();

                $message->setContact($contact);

                $entityManager->persist($message);
                $entityManager->flush();

                if ($contact->getInscriptionCont() == 1) {
                    $email = (new TemplatedEmail())
                        ->from('cuisine.saintvincentsenlis@gmail.com')
                        ->to($contact->getMailCont())
                        ->subject('Votre newsletter')
                        ->htmlTemplate('email/send_newsletter.html.twig')
                        ->context([
                            'user' => $contact->getMailCont(),
                            'offre' => $offreRecent
                        ]);
                    /*Envoie d'un email*/
                    $mailer->send($email);
                }

                /*Message d'erreur*/
                $this->addFlash(
                    'succesContact',
                    'Votre formulaire a été envoyée !'
                );
            }
            else {
                /*Message d'erreur*/
                $this->addFlash(
                    'erreurContact',
                    'Votre formulaire n\'a pas été envoyée !'
                );
            }
            return $this->redirectToRoute('app_contact');

        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
