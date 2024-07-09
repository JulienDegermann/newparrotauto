<?php

namespace App\Controller;

use App\Repository\CarRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        CarRepository $carRepository
    ): Response {
        
        $cars = $carRepository->getAllCars();
        $services = [
            "occasions" => [
                "berline",
                "citadine",
                "utilitaire",
            ],
            "entretien" => [
                "pneumatique",
                "vidange",
                "freinage",
                "batterie",
                "climatisation",
                "échappement",
                "amortisseurs",
                "courroie de distribution"
            ],
            "réparation" => [
                "carrosserie",
                "pare-brise",


            ],
        ];

        $comments = [
            [
                "name" => "Jean",
                "text" => "Super garage, je recommande !",
                "note" => 5
            ],
            [
                "name" => "Paul",
                "text" => "Très bon accueil, je reviendrai !",
                "note" => 3
            ]
        ];

        return $this->render('home/index.html.twig', [
            'cars' => $cars,
            'services' => $services,
            'comments' => $comments
        ]);
    }
}
