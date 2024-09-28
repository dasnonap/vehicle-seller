<?php

namespace App\Services;

use App\Entity\AccessToken;
use App\Repository\UserRepository;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $userPasswordHasher,
    ) {}

    /**
     * Create User or fail if already exists
     * @param Request $request the Incomming Request
     * @return User|null return the newly added User or fail
     */
    public function createOrFail(Request $request): User
    {
        $body = json_decode($request->getContent(), true);

        $user = new User();
        $user->setFirstName($body['first_name']);
        $user->setLastName($body['last_name']);
        $user->setPassword(
            $this->userPasswordHasher->hashPassword($user, $body['password'])
        );
        $user->setRoles($body['role'] ?? []);
        $user->setEmail($body['email']);

        // validate user

        if (!$this->checkIfUserIsUnique($user)) {
            throw new LogicException("User with this email already exists!");
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * Validate User is Unique by email
     * @param User $user the user to validate
     * @return bool 
     */
    public function checkIfUserIsUnique(User $user): bool
    {
        return empty($this->userRepository->findOneBy(['email' => $user->getEmail()]));
    }

    /**
     * Find user by credentials or fail
     * @param Request $request the incomming request 
     * @return User the found User
     *
     */
    public function findOrFail(Request $request): User
    {
        $body = json_decode($request->getContent(), true);

        $found_user = $this->userRepository->findOneBy(
            [
                'email' => $body['email'],
            ]
        );

        if ($found_user === null) {
            throw new LogicException('No users found with the provided email & password combination.');
        }

        if (! $this->userPasswordHasher->isPasswordValid($found_user, $body['password'])) {
            throw new LogicException('No users found with the provided email & password combination.');
        }

        return $found_user;
    }

    public function findByAccessToken(string $token): User
    {
        $accessTokenRepo = $this->entityManager->getRepository(AccessToken::class);

        $accessToken = $accessTokenRepo->findOneBy([
            'token' => $token
        ]);

        if (empty($accessToken)) {
            throw new CustomUserMessageAuthenticationException("Can't find user with provided token.");
        }

        return $accessToken->getUser();
    }
}
