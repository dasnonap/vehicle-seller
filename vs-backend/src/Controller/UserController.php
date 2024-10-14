<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    public function __construct(
        public Security $security
    ) {}

    #[Route('/api/user/index', name: 'app_user_fetch', methods: ['POST'])]
    public function index(): JsonResponse
    {
        $currentUser = $this->security->getUser();

        return $this->json([
            'user' => $currentUser->getUserData()
        ]);
    }
}
