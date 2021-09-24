<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $password_encoder)
    {
        $this->password_encoder = $password_encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        foreach($this->getUserData() as [$name, $email, $password, $roles])
        {
            $user = new User();
            $user->setName($name);
            $user->setEmail($email);
            $user->setPassword($this->password_encoder->encodePassword($user, $password));
            $user->setRoles($roles);

            $manager->persist($user);
        }
        $manager->flush();
    }

    private function getUserData(): array 
    {
        return [
            ["Adam", "adam.wojdylo1234@gmail.com", "learning123", ['ROLE_ADMIN']],
            ["Kamil", "kamil.stoch@gmail.com", "skoki250", ['ROLE_USER']],
            ["Heynen", "heynen.siatkowka@PZPN.pl", "worekmedali", ['ROLE_USER']]
        ];
    }
}
