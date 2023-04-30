<?php

namespace App\DataFixtures;

use App\Entity\Partenaire;
use App\Entity\Fichier;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PartenaireFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Créer une nouvelle instance de Partenaire
        $partenaire = new Partenaire();
        $partenaire->setNomPart('Partenaire 1');
        $partenaire->setDescPart('Description du partenaire 1');
        $partenaire->setLienPart('https://www.example.com/partenaire1');

        // Récupérer un fichier existant pour associer au partenaire
        $fichier = $manager->getRepository(Fichier::class)->findOneBy(['nomFichier' => 'fichier1.txt']);
        if ($fichier) {
            $partenaire->setFichierPart($fichier);
        }

        // Persistir l'entité dans la base de données
        $manager->persist($partenaire);

        // Enregistrer les changements dans la base de données
        $manager->flush();
    }
}

?>