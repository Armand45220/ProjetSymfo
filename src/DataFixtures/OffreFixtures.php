<?php

namespace App\DataFixtures;

use App\Entity\Offre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OffreFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
                // Création de quelques offres de test
                $offre1 = new Offre();
                $offre1->setNomOffre("Offre 1");
                $offre1->setDescOffre("Description de l'offre 1");
                $offre1->setLienOffre("https://exemple.com/offre1");
                $offre1->setDateDebutVal(new \DateTime("-2 weeks"));
                $offre1->setDateFinVal(new \DateTime("+1 month"));
                $offre1->setDateDebutAff(null);
                $offre1->setDateFinAff(null);
                $offre1->setDateInsertOffre(new \DateTime());
                $offre1->setNumAff(1);
                $offre1->setNbPlacesMin(10);
                $offre1->setTypeOffre(1);
                
                $offre2 = new Offre();
                $offre2->setNomOffre("Offre 2");
                $offre2->setDescOffre("Description de l'offre 2");
                $offre2->setLienOffre("https://exemple.com/offre2");
                $offre2->setDateDebutVal(null);
                $offre2->setDateFinVal(null);
                $offre2->setDateDebutAff(new \DateTime());
                $offre2->setDateFinAff(new \DateTime("+2 days"));
                $offre2->setDateInsertOffre(new \DateTime());
                $offre2->setNumAff(3);
                $offre2->setNbPlacesMin(5);
                $offre2->setTypeOffre(2);


                $offre3 = new Offre();
                $offre3->setNomOffre("Offre 3");
                $offre3->setDescOffre("Description de l'offre 3");
                $offre3->setLienOffre("https://exemple.com/offre3");
                $offre3->setDateDebutVal(null);
                $offre3->setDateFinVal(null);
                $offre3->setDateDebutAff(new \DateTime());
                $offre3->setDateFinAff(new \DateTime("+2 days"));
                $offre3->setDateInsertOffre(new \DateTime());
                $offre3->setNumAff(3);
                $offre3->setNbPlacesMin(5);
                $offre3->setTypeOffre(2);

                
    
                
                // Ajouter les offres à la gestionnaire d'entités (EntityManager)
                $manager->persist($offre1);
                $manager->persist($offre2);
                $manager->persist($offre3);
                $manager->flush();
    }
}