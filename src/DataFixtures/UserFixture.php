<?php

namespace App\DataFixtures;

use Admin\Enum\UserRole;
use Admin\Enum\UserState;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    public const REGULAR_USER_REFERENCE = 'regular-user';
    public const ADMIN_USER_REFERENCE = 'admin-user';
    public const SUPER_ADMIN_USER_REFERENCE = 'super-admin-user';

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher) {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $users = [
            $this->getAdminUser(),
            $this->getRegularUser(),
            $this->getSuperAdminUser(),
        ];

        foreach ($users as $user) {
            $password = $this->passwordHasher->hashPassword($user, 'a1s2d3f4');
            $user->setPassword($password);

            $manager->persist($user);
        }

        $manager->flush();
    }

    private function getSuperAdminUser(): User
    {
        $user = new User();
        $user->setEmail('superadmin@test.com');
        $user->setFirstName('Super');
        $user->setLastName('Admin');
        $user->addRoles(
            UserRole::ROLE_USER,
            UserRole::ROLE_ADMIN,
            UserRole::ROLE_SUPER_ADMIN,
        );
        $user->setState(UserState::VERIFIED);
        $user->setIsVerified(true);
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setUpdatedAt(new \DateTimeImmutable());

        $this->addReference(self::SUPER_ADMIN_USER_REFERENCE, $user);

        return $user;
    }

    private function getAdminUser(): User
    {
        $user = new User();
        $user->setEmail('admin@test.com');
        $user->setFirstName('Admin');
        $user->setLastName('User');
        $user->addRoles(
            UserRole::ROLE_USER,
            UserRole::ROLE_ADMIN,
        );
        $user->setState(UserState::VERIFIED);
        $user->setIsVerified(true);
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setUpdatedAt(new \DateTimeImmutable());

        $this->addReference(self::ADMIN_USER_REFERENCE, $user);

        return $user;
    }

    private function getRegularUser(): User
    {
        $user = new User();
        $user->setEmail('user@test.com');
        $user->setFirstName('Regular');
        $user->setLastName('User');
        $user->addRoles(UserRole::ROLE_USER);
        $user->setState(UserState::VERIFIED);
        $user->setIsVerified(true);
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setUpdatedAt(new \DateTimeImmutable());

        $this->addReference(self::REGULAR_USER_REFERENCE, $user);

        return $user;
    }
}
