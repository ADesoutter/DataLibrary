<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProdFixtures extends Fixture implements FixtureGroupInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public static function getGroups(): array
    {
        // Cette fixture fait partie du groupe "prod".
        // Cela permet de cibler seulement certains fixtures
        // quand on exécute la commande doctrine:fixtures:load.
        // Pour que la méthode statique getGroups() soit prise
        // en compte, il faut que la classe implémente
        // l'interface FixtureGroupInterface.
        return ['prod'];
    }

    public function load(ObjectManager $manager)
    {
        // Création des comptes admins
        $this->loadAdmin($manager);

        // Exécution des requêtes.
        // C-à-d envoi de la requête SQL à la BDD.
        $manager->flush();
    }
    
    public function loadAdmins(ObjectManager $manager)
    {
        //L' utilisateur avec un role ADMIN
        $user = new User();
        $user->setEmail('admin@example.com');
        $password = $this->encoder->encodePassword($user, '123');
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);
    }
}
