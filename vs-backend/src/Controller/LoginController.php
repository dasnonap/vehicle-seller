<?php

namespace App\Controller;

use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Services\AuthService;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

class LoginController extends AbstractController
{
    public function __construct(
        private UserService $userService,
        private AuthService $authService
    ) {}

    #[Route('/api/login', name: 'app_user_login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        try {
            $user = $this->userService->findOrFail($request);

            $accessToken = $this->authService->createUserToken($user);
        } catch (\Throwable $th) {
            //throw $th;
            echo '<pre>';
            dump($th);
            echo '</pre>';
            exit;
        }

        echo '<pre>';
        dump($user, $accessToken);
        echo '</pre>';
        exit;


        return $this->json([
            'user' => $user->getId(),
            'token' => $accessToken->getToken(),
        ]);
    }
}
