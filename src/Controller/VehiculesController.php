<?php

namespace App\Controller;

use App\Repository\CarRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VehiculesController extends AbstractController
{
    #[Route('/nos-occasions', name: 'app_vehicules')]
    public function index(
        CarRepository $carRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {

        $cars = $carRepository->findAll();

        $paginated = $paginator->paginate(
            $cars,
            $request->query->getInt('page', 1),
            9
        );

        return $this->render('Vehicules/index.html.twig', [
            'cars' => $paginated
        ]);
    }

    #[Route('/nos-occasions/{id}', name: 'app_vehicule_show')]
    public function detail(
        CarRepository $carRepository,
        $id
    ): Response {
        
        $car = $carRepository->findOneBy(['id' => $id]);

        return $this->render('Vehicules/detail.html.twig', [
            'car' => $car
        ]);
    }
}
