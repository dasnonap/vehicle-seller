<?php

namespace App\Services;

use App\Repository\UserRepository;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
}
