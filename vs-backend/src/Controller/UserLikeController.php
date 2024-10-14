<?php

namespace App\Controller;

use App\Services\LikeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Vehicle;

class UserLikeController extends AbstractController
{
    public function __construct(
        public LikeService $likeService
    ) {}

    #[Route('/api/vehicles/{vehicle}/like', name: 'app_user_like', methods: ['GET'])]
    public function index(Vehicle $vehicle): JsonResponse
    {
        $result = $this->likeService->like($vehicle);

        return $this->json([
            'response' => $result
        ]);
    }
}
