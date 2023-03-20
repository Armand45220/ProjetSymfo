<?php

namespace App\Controller;

use App\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Reponse;


class QuestionController extends AbstractController
{
    public function showQuestionAction($id, EntityManagerInterface $entityManager)
    {
        $question = $entityManager->getRepository(Question::class)->findOneBy(array('id_question'=> $id));

        if (!$question) {
            throw $this->createNotFoundException('Question non trouvée');
        }

        $reponses = $entityManager->getRepository(Reponse::class)->findBy(array('questions'=>$question));
        return $this->render('includes/survey.html.twig', [
            'question' => $question,
            'reponses' => $reponses,
        ]);
    }
}
?>
