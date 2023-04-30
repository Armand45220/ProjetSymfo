<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordEncoder = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {

            // Créer une nouvelle instance d'User
            $user = new Utilisateur();
            $user->setUsername('john_doe');
            $user->setRoles(['ROLE_USER']);
    
            // Hacher le mot de passe "password" en utilisant la fonction hashPassword()
            $hashedPassword = $this->passwordEncoder->hashPassword($user, 'password');
            $user->setPassword($hashedPassword);
    
            // Persistir l'entité dans la base de données
            $manager->persist($user);
    
            // Enregistrer les changements dans la base de données
            $manager->flush();
    }
}

?>