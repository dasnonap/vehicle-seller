<?php

namespace App\Controller;

use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

class UserController extends AbstractController
{
    public function __construct(
        private UserService $userService,
    ) {}

    #[Route('/api/users/create', name: 'app_user_register')]
    public function create(Request $request): JsonResponse
    {
        try {
            $user = $this->userService->createOrFail($request);
        } catch (Throwable $th) {
            return $this->handleErrors($th);
        }

        return $this->json([
            'user' => $user->getId(),
        ]);
    }

    /**
     * Handle Exception Errors
     * @param Throwable $th the Throwable 
     */
    public function handleErrors(Throwable $th): JsonResponse
    {
        return $this->json([
            "error" => $th->getMessage(),
        ], 409);
    }
}
