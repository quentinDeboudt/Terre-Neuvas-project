<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager ){
        $this->addUser($manager);

    }
    public function addUser($manager)
    {

        //#################### user 1 #############################
        $user = new User();


        // hash the password (based on the security.yaml config for the $user class)
        $plaintextPassword = 123;
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );

        $user->setPassword($hashedPassword);
        $user->setUsername('Quentin');
        $user->setRoles((array)'ROLE_ADMIN');

        $manager->persist($user);
        $manager->flush();
        }
    }
