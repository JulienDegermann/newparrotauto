<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\StoreRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        CommentRepository $commentRepository,
        StoreRepository $storeRepository
    ): Response {

        // get datas from database (company and stores)
        $stores = $storeRepository->findAll();
        $comments = $commentRepository->findApprovedComments();

        // dd($comments);

        $services = [
            "occasions" => [
                "image" => "sell.jpg",
                "details" => "Nos véhicules d'occasions sont tous révisés et garantis jusqu'à 12 mois. De la citadine au SUV, en n'oubliant pas les utilitaires, nous avons forcément le véhicule qu'il vous faut."
            ],
            "entretien" => [
                "image" => "revision.jpg",
                "details" => "Nous proposons une large gamme de prestations pour l'entretien de votre véhicule : pneumatiques, vidange, freinage, batterie, climatisation, échappement, amortisseurs, courroie de distribution, embrayage, diagnostic électronique, pré-contrôle technique, contrôle technique, etc."
            ],
            "réparation" => [
                "image" => "repair.jpg",
                "details" => "Accrochage, accident ou panne moteur, nous réparons votre véhicule endommagé avec des pièces neuves ou d'occasion."


            ],
        ];

        return $this->render('home/index.html.twig', [
            'comments' => $comments,
            'services' => $services,
            'comments' => $comments,
            'stores' => $stores
        ]);
    }
}
