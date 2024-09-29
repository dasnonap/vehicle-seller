<?php

namespace App\Services;

use App\Entity\User;
use App\Entity\AccessToken;
use DateInterval;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;

class AuthService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    /**
     * Create User Token
     * @param User $user 
     * @return AccessToken 
     */
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

    /**
     * Validate User Token
     * @param AccessToken $accessToken the token to validate
     * @return bool whether the token is valid
     */
    public function validateAccessToken(AccessToken $accessToken): bool
    {
        $current_time = new DateTime('now');
        $expire_time = $accessToken->getCreatedDate()->modify('+ 1 hour');

        return $current_time < $expire_time;
    }

    private function generateUserToken(User $user): string
    {
        return uniqid(rand());
    }
}
