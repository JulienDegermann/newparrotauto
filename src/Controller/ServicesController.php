<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\CompanyRepository;
use App\Repository\StoreRepository;
use App\Traits\Pages\DatasTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ServicesController extends AbstractController
{
    use DatasTrait;

    #[Route('/services', name: 'app_services')]
    public function index(
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


        return $this->render('services/index.html.twig', [
            'store' => $storeExport,
            'stores' => $stores,
            'params' => $params,
            'company' => $compagny,
        ]);
    }
}
