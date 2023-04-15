<?php

namespace App\DataFixtures;

use App\Entity\Fichier;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FichierFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Créer une nouvelle instance de Fichier
        $fichier = new Fichier();
        $fichier->setNomFichier('fichier1.txt');
        $fichier->setCheminFichier('/chemin/vers/fichier1.txt');

        // Persistir l'entité dans la base de données
        $manager->persist($fichier);

        // Enregistrer les changements dans la base de données
        $manager->flush();
    }
}

?>