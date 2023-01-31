<?php

namespace App\Controller;

use App\Entity\EmailContact;
use App\Repository\ActionRepository;
use App\Repository\AProposRepository;
use App\Repository\EmailContactRepository;
use App\Repository\FichierRepository;
use App\Repository\MembreRepository;
use App\Repository\ReglementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AProposController extends AbstractController
{
    #[Route('/APropos', name: 'app_apropos')]
    public function index(MembreRepository $membreRepository, ActionRepository $actionRepository, FichierRepository $fichierRepository, AProposRepository $AProposRepository): Response
    {
        return $this->render('APropos/index.html.twig', [
            'infos_membre' => $membreRepository->findAll(),
            'infos_action' => $actionRepository->findAll(),
            'infos_fichier' => $fichierRepository->findAll(),
            'infos_aPropos' => $AProposRepository->findAll(),

        ]);
    }
}
