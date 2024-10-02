<?php

namespace App\Services;

use App\Entity\Vehicle;
use App\Entity\Car;
use App\Repository\VehicleRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Mapping\ClassMetadata;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;
use LogicException;

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

    /**
     * Create Vehicle or Fail
     * @param Request $request to extract the data from
     * @param Vehicle the imported entity from Vehicle type
     */
    public function createOrFail(Request $request): Vehicle
    {
        $requestBody = json_decode($request->getContent(), true);
        list('vehicle_args' => $vehicleArgs, 'type_specs' => $typeSpecs) = $requestBody;

        if (!$this->checkIfVehicleIsInserted($vehicleArgs['vin'])) {
            throw new LogicException(sprintf("Vehicle with VIN: %s, already inserted", $vehicleArgs['vin']));
        }

        $vehicle = $this->getVehicleTypeClass($typeSpecs);

        $vehicle->setBrand($vehicleArgs['brand']);
        $vehicle->setModel($vehicleArgs['model']);
        $vehicle->setPrice($vehicleArgs['price']);
        $vehicle->setQuantity($vehicleArgs['quantity']);
        $vehicle->setVin($vehicleArgs['vin']);


        $this->entityManager->persist($vehicle);
        $this->entityManager->flush();

        return $vehicle;
    }

    // Use this to get the Mapping tables of the child Classes
    private function getVehicleTypeClass(array $type_specs): Vehicle
    {
        $vehicleMapping = $this->entityManager->getClassMetadata(Vehicle::class)->discriminatorMap ?? [];

        $vehicleTypeClass = $vehicleMapping[$type_specs['type']];

        if (empty($vehicleTypeClass)) {
            throw new LogicException('Vehicle must have type mapping.');
        }

        $vehicle = null;

        if ($vehicleTypeClass == Car::class) {
            $vehicle = new Car();

            $vehicle->setEngineCapacity($type_specs['engine_capacity']);
            $vehicle->setColour($type_specs['colour']);
            $vehicle->setDoors($type_specs['doors']);
            $vehicle->setCategory($type_specs['category']);
        }

        return $vehicle;
    }

    // Check if vehicle VIN is already inserted
    private function checkIfVehicleIsInserted(string $vin): bool
    {
        return empty($this->vehicleRepository->findOneBy(['vin' => $vin]));
    }
}
