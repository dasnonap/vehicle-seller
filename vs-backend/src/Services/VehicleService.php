<?php

namespace App\Services;

use App\Entity\Vehicle;
use App\Repository\VehicleRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;

class VehicleService
{
    private int $postsPerPage = 2;

    public function __construct(
        public EntityManagerInterface $entityManager,
        public VehicleRepository $vehicleRepository,
    ) {}

    /**
     * Fetch and paginate Vehicles ordered by price
     * @param int $page the page to fetch
     * @return array of vehicles
     */
    public function fetch(int $page = 1): array
    {
        $queryBuilder = $this->vehicleRepository->fetchVehicles();

        $pager = Pagerfanta::createForCurrentPageWithMaxPerPage(
            new QueryAdapter($queryBuilder),
            $page,
            $this->postsPerPage
        );

        return [
            'vehicles' => array_map(function (Vehicle $vehicle) {
                return $vehicle->toArray();
            }, iterator_to_array($pager->getCurrentPageResults())),
            'current_page' => $page,
            'total_pages' => $pager->getNbPages(),
        ];
    }
}
