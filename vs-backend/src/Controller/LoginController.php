<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Motorcycle;
use App\Entity\Trailer;
use App\Entity\Truck;
use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Services\AuthService;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;


class LoginController extends AbstractController
{
    public function __construct(
        private UserService $userService,
        private AuthService $authService,
        private Security $security,
    ) {}

    #[Route('/api/login', name: 'app_user_login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        try {
            $user = $this->userService->findOrFail($request);

            $accessToken = $this->authService->createUserToken($user);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $this->json([
            'user' => $user->getId(),
            'token' => $accessToken->getToken(),
        ]);
    }

    #[Route('/test', name: 'api_route_test', methods: ['POST'])]
    public function test(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $motorcycle = new Motorcycle();

        $motorcycle->setBrand('Honda');
        $motorcycle->setModel('Super Cub C125');
        $motorcycle->setPrice(8500);
        $motorcycle->setQuantity(1);
        $motorcycle->setEngineCapacity(125);
        $motorcycle->setColour('red');
        $motorcycle->setVin("8811DE");

        $em->persist($motorcycle);
        $em->flush();

        $car = new Car();

        $car->setBrand('VW');
        $car->setModel('Polo');
        $car->setPrice(30000);
        $car->setQuantity(1);
        $car->setEngineCapacity(2000);
        $car->setCategory('hatchback');
        $car->setDoors(5);
        $car->setColour('black');
        $car->setVin('895112E');

        $em->persist($car);
        $em->flush();

        $truck = new Truck();

        $truck->setBrand('Volvo');
        $truck->setModel('FH');
        $truck->setEngineCapacity(12000);
        $truck->setColour('black');
        $truck->setNumberOfBeds(2);
        $truck->setPrice(50000);
        $truck->setQuantity(1);
        $truck->setVin('2211ED');

        $em->persist($truck);
        $em->flush();

        $trailer = new Trailer();

        $trailer->setBrand("Example trailer");
        $trailer->setModel("trailer model");
        $trailer->setLoadCapacity(6000);
        $trailer->setNumberOfAxles(1);
        $trailer->setPrice(20000);
        $trailer->setQuantity(1);
        $trailer->setVin('2212DE1R');

        $em->persist($trailer);
        $em->flush();

        echo '<pre>';
        dump($motorcycle, $car, $trailer, $truck);
        echo '</pre>';
        exit;
    }
}
