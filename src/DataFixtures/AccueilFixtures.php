<?php

namespace App\DataFixtures;

use App\Entity\Accueil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AccueilFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Créer une nouvelle instance d'Accueil
        $accueil = new Accueil();
        $accueil->setMessPresAcc('Message de présentation de l\'accueil');

        // Persistir l'entité dans la base de données
        $manager->persist($accueil);

        // Enregistrer les changements dans la base de données
        $manager->flush();
    }
}

?>