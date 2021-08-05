<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersFixtures extends Fixture
{

    public function __construct(UserPasswordEncoderInterface $password_encoder)
    {
        $this->password_encoder = $password_encoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [
            $name,
            $last_name,
            $email,
            $password,
            $api_key,
            $roles
        ]) {
            $user = new User();
            $user->setName($name);
            $user->setLastName($last_name);
            $user->setEmail($email);
            $user->setPassword($this->password_encoder->encodePassword($user, $password));
            $user->setVimeoApiKey($api_key);
            $user->setRoles($roles);
            $manager->persist($user);
        }

        $manager->flush();
    }

    private function getUserData(): array
    {
        return [
            ['John', 'Wayne', 'jw@symf4.loc', '1Password', 'hjd8dehdh', ['ROLE_ADMIN']],
            ['John', 'Uy', 'jw@symf43.loc', '1Password', 'hjd8dehdh', ['ROLE_ADMIN']],
            ['John', 'Ai', 'jw@symf34.loc', '1Password', 'hjd8dehdh', ['ROLE_USER']],
        ];
    }
}
