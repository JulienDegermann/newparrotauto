<?php

namespace App\Controller;

use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VehiculesController extends AbstractController
{
    #[Route('/nos-occasions', name: 'app_vehicules')]
    public function index(
        CarRepository $carRepository
    ): Response {
        $cars = $carRepository->findAll();

        // dd($cars);

        return $this->render('Vehicules/index.html.twig', [
            'cars' => $cars
        ]);
    }
}
