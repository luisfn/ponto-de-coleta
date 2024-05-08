<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class UserFixture extends Fixture
{
    public const ADMIN_USER_REFERENCE = 'admin-user';

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher) {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin@test.com');
        $admin->setFirstName('Admin');
        $admin->setLastName('Test');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setState('verified');
        $admin->setCreatedAt(new \DateTimeImmutable());
        $admin->setUpdatedAt(new \DateTimeImmutable());

        $password = $this->passwordHasher->hashPassword($admin, 'a1s2d3f4');
        $admin->setPassword($password);

        $manager->persist($admin);
        $manager->flush();

        $this->addReference(self::ADMIN_USER_REFERENCE, $admin);
    }
}
