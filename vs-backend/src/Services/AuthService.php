<?php

namespace App\Services;

use App\Entity\User;
use App\Entity\AccessToken;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;

class AuthService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function createUserToken(User $user): AccessToken
    {
        $this->invalidateAccessToken($user);

        $userToken = new AccessToken();
        $userToken->setUser($user);
        $userToken->setToken($this->generateUserToken($user));
        $userToken->setCreatedDate(new DateTime('now'));

        $user->setAccessToken($userToken);

        $this->entityManager->persist($userToken);
        $this->entityManager->flush();

        return $userToken;
    }

    /**
     * Invalidate User AccessToken
     * @param User $user to search for
     * @return void
     */
    public function invalidateAccessToken(User $user): void
    {
        $userAccessToken = $user->getAccessToken();

        if (empty($userAccessToken)) {
            return;
        }

        $userAccessToken->setUser(new User());
        $this->entityManager->remove($userAccessToken);
        $this->entityManager->flush();
    }

    private function generateUserToken(User $user): string
    {
        return uniqid(rand());
    }
}
