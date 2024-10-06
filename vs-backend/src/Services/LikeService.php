<?php

namespace App\Services;

use App\Entity\Vehicle;
use App\Entity\User;
use App\Entity\UserVehicleLike;
use App\Repository\UserVehicleLikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use App\Exceptions\VehicleAlreadyLikedException;

class LikeService
{
    private User $currentUser;

    public function __construct(
        public Security $security,
        public EntityManagerInterface $entityManager,
        public UserVehicleLikeRepository $userLikeRepo
    ) {
        $this->currentUser = $this->security->getUser();
    }

    function like(Vehicle $vehicle): bool
    {
        $user_like = new UserVehicleLike();

        if ($this->checkIfVehicleIsLiked($vehicle)) {
            throw new VehicleAlreadyLikedException("Vehicle is already added to Liked list.");
        }
        $user_like->setUser($this->currentUser);
        $user_like->setVehicle($vehicle);

        $this->entityManager->persist($user_like);
        $this->entityManager->flush();

        return ! empty($user_like->getUser()) || ! empty($user_like->getVehicle());
    }

    function checkIfVehicleIsLiked(Vehicle $vehicle): bool
    {
        return ! empty($this->userLikeRepo->findByUserAndVehicle($this->currentUser->getId(), $vehicle->getId()));
    }
}
