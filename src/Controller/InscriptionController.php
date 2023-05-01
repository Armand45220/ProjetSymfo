<?php
namespace App\Controller;

use App\Repository\ContactRepository;
use App\Form\FormInscription;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class InscriptionController extends AbstractController
{
// Dans le contrôleur qui gère l'inscription
    public function register(Request $request, \Swift_Mailer $mailer, ContactRepository $contactRepository, EntityManagerInterface $entityManager): Response
    {
// Créer le formulaire d'inscription avec un champ email
        $form = $this->createForm(FormInscription::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
// Récupérer les données du formulaire
            $user = $form->getData();

// Créer un nouvel utilisateur avec le statut d'inscription initial à 0
            $user->setIsRegistered(false);

// Envoyer un email à l'utilisateur pour confirmer son inscription
            $message = (new \Swift_Message('Confirmation d\'inscription'))
                ->setFrom('noreply@monsite.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'emails/registration.html.twig',
                        ['user' => $user]
                    ),
                    'text/html'
                );
            $mailer->send($message);

// Mettre à jour le statut d'inscription de l'utilisateur en le passant à 1
            $user->setIsRegistered(true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}