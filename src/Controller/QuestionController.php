<?php

namespace App\Controller;

use App\Entity\Reponse;
use App\Form\ReponseType;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    private $entityManager;
    private $questionRepository;

    public function __construct(EntityManagerInterface $entityManager, QuestionRepository $questionRepository)
    {
        $this->entityManager = $entityManager;
        $this->questionRepository = $questionRepository;
    }

    #[Route("/", name:"sondage_index")]

    public function QuestionShow(Request $request): Response
    {
        $question = $this->questionRepository->findOneBy(["dispo_question" => 1]);
        $reponse = new Reponse();
        $form = $this->createForm(ReponseType::class, $reponse);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reponse = $form->getData();

            $this->entityManager->persist($reponse);
            $this->entityManager->flush();

            return $this->redirectToRoute('sondage_index');
        }
        
        return $this->render('includes/survey.html.twig', [
            'question' => $question,
            'form' => $form->createView(),
        ]);
    }
}
?>
