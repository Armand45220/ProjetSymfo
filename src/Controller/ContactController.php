<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\MessUtilisateur;
use App\Form\FormType;
use App\Repository\ContactRepository;
use App\Repository\MessUtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $entityManager,  MessUtilisateurRepository $messUtilisateurRepository): Response
    {
        $contact = new Contact();
        $message = new MessUtilisateur();

        $form = $this->createForm(FormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
