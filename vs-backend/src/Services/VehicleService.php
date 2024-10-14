<?php

namespace App\Services;

use App\Entity\Vehicle;
use App\Entity\Car;
use App\Entity\Motorcycle;
use App\Entity\Truck;
use App\Entity\Trailer;
use App\Repository\VehicleRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Mapping\ClassMetadata;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;
use LogicException;
use Symfony\Bundle\SecurityBundle\Security;

class VehicleService
{
    private int $postsPerPage = 10;

    public function __construct(
        public EntityManagerInterface $entityManager,
        public VehicleRepository $vehicleRepository,
        public Security $security,
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
        // dd($requestBody);
        list('vehicle_args' => $vehicleArgs, 'type_specs' => $typeSpecs) = $requestBody;

        if (!$this->checkIfVehicleIsInserted($vehicleArgs['vin'])) {
            throw new LogicException(sprintf("Vehicle with VIN: %s, already inserted", $vehicleArgs['vin']));
        }

        $user = $this->security->getUser();

        $vehicle = $this->createVehicleTypeInstance($typeSpecs);

        // Set the Generic Vehicle attributes
        $vehicle->setBrand($vehicleArgs['brand']);
        $vehicle->setModel($vehicleArgs['model']);
        $vehicle->setPrice($vehicleArgs['price']);
        $vehicle->setQuantity($vehicleArgs['quantity']);
        $vehicle->setVin($vehicleArgs['vin']);

        $vehicle->setUser($user);

        $this->entityManager->persist($vehicle);
        $this->entityManager->flush();

        return $vehicle;
    }

    /**
     * Create Vehicle Type Instance Object
     * @param array $type_specs the specific type specs for the VehicleType
     * @return Vehicle the created instance
     */
    private function createVehicleTypeInstance(array $type_specs): Vehicle
    {
        $vehicleMapping = $this->entityManager->getClassMetadata(Vehicle::class)->discriminatorMap ?? [];

        $vehicleTypeClass = $vehicleMapping[$type_specs['type']];

        if (empty($vehicleTypeClass)) {
            throw new LogicException('Vehicle must have type mapping.');
        }

        $vehicle = match ($vehicleTypeClass) {
            Car::class => new Car(),
            Motorcycle::class => new Motorcycle(),
            Truck::class => new Truck(),
            Trailer::class => new Trailer(),
            default => null
        };

        if ($vehicle === null) {
            throw new LogicException("Couldn't create vehicle.");
        }

        $vehicle->initFromArray($type_specs);

        return $vehicle;
    }

    // Check if vehicle VIN is already inserted
    private function checkIfVehicleIsInserted(string $vin): bool
    {
        return empty($this->vehicleRepository->findOneBy(['vin' => $vin]));
    }
}
