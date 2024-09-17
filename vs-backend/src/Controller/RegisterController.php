<?php

namespace App\Controller;

use App\Services\UserService;
use App\Services\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

class RegisterController extends AbstractController
{
    public function __construct(
        private UserService $userService,
        private AuthService $authService,
    ) {}

    #[Route('/api/register', name: 'app_user_register', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        try {
            $user = $this->userService->createOrFail($request);

            $accessToken = $this->authService->createUserToken($user);
        } catch (Throwable $th) {
            return $this->handleErrors($th);
        }

        return $this->json([
            'user' => $user->getId(),
            'token' => $accessToken->getToken(),
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
