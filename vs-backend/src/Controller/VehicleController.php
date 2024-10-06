<?php

namespace App\Controller;

use App\Services\VehicleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class VehicleController extends AbstractController
{
    function __construct(
        public VehicleService $vehicleService
    ) {}

    #[Route('/api/vehicles', name: 'app_vehicles_index', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {
        $requestBody = json_decode($request->getContent(), true);
        $page = $requestBody['page'] ?? 1;

        $vehicles = $this->vehicleService->fetch($page);

        return $this->json($vehicles);
    }

    #[Route('/api/vehicles/create', name: 'app_vehicles_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $vehicle = $this->vehicleService->createOrFail($request);

        return $this->json([
            'success' => true
        ]);
    }
}
