<?php

namespace App\Controller;

use App\Repository\CarRepository;
use App\Repository\CompanyRepository;
use App\Repository\StoreRepository;
use App\Traits\Pages\DatasTrait;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class VehiculesController extends AbstractController
{

    use DatasTrait;

    #[Route('/nos-occasions', name: 'app_vehicules')]
    public function index(
        CarRepository $carRepository,
        PaginatorInterface $paginator,
        Request $request,
        StoreRepository $storeRepository,
        SerializerInterface $serializer,
        CompanyRepository $companyRepository
    ): Response {

        $datas = $this->getDatas($request, $storeRepository, $companyRepository, $serializer);
        $storeExport = $datas['storeExport'];
        $stores = $datas['allStores'];
        $params = $datas['params'];
        $compagny = $datas['company'];


        $cars = $carRepository->findAll();

        $paginated = $paginator->paginate(
            $cars,
            $request->query->getInt('page', 1),
            9
        );

        return $this->render('Vehicules/index.html.twig', [
            'cars' => $paginated,
            'store' => $storeExport,
            'stores' => $stores,
            'params' => $params,
            'company' => $compagny,
        ]);
    }

    #[Route('/nos-occasions/{id}', name: 'app_vehicule_show')]
    public function detail(
        CarRepository $carRepository,
        PaginatorInterface $paginator,
        Request $request,
        StoreRepository $storeRepository,
        SerializerInterface $serializer,
        CompanyRepository $companyRepository,
        $id
    ): Response {

        $datas = $this->getDatas($request, $storeRepository, $companyRepository, $serializer);
        $storeExport = $datas['storeExport'];
        $stores = $datas['allStores'];
        $params = $datas['params'];
        $compagny = $datas['company'];
        
        $car = $carRepository->findOneBy(['id' => $id]);

        return $this->render('Vehicules/detail.html.twig', [
            'car' => $car,
            'store' => $storeExport,
            'stores' => $stores,
            'params' => $params,
            'company' => $compagny,
        ]);
    }
}
