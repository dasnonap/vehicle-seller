<?php

namespace App\Repository;

use App\Entity\UserVehicleLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserVehicleLike>
 */
class UserVehicleLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserVehicleLike::class);
    }

    /**
     * Search
     * @return UserVehicleLike[] Returns an array of UserVehicleLike objects
     */
    public function findByUserAndVehicle(int $user_id, int $vehicle_id): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.user = :user_id_val')
            ->andWhere('u.vehicle = :vehicle_id_val')
            ->setParameter('user_id_val', $user_id)
            ->setParameter('vehicle_id_val', $vehicle_id)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    //    public function findOneBySomeField($value): ?UserVehicleLike
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
