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

    #[Route('/api/vehicles', name: 'app_vehicle')]
    public function index(Request $request): JsonResponse
    {
        $requestBody = json_decode($request->getContent(), true);
        $page = $requestBody['page'] ?? 1;

        try {
            $vehicles = $this->vehicleService->fetch($page);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $this->json($vehicles);
    }
}
