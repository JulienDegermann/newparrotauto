<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\CarRepository;
use App\Repository\CompanyRepository;
use App\Repository\MessageRepository;
use App\Repository\StoreRepository;
use App\Repository\UserRepository;
use App\Traits\Pages\CreateFormTrait;
use App\Traits\Pages\DatasTrait;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class VehiculesController extends AbstractController
{

    use DatasTrait;
    use CreateFormTrait;

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
        Request $request,
        StoreRepository $storeRepository,
        SerializerInterface $serializer,
        CompanyRepository $companyRepository,
        MessageRepository $messageRepository,
        UserRepository $userRepository,
        int $id
    ): Response {

        $datas = $this->getDatas($request, $storeRepository, $companyRepository, $serializer);
        $storeExport = $datas['storeExport'];
        $stores = $datas['allStores'];
        $params = $datas['params'];
        $compagny = $datas['company'];

        $car = $carRepository->findOneBy(['id' => $id]);

        $form = $this->newMessage('app_vehicules', $request, $messageRepository, $userRepository);
        
        // check if form is a redirect response (form is valid)
        if ($form instanceof RedirectResponse) {
            return $form;
        }


        return $this->render('Vehicules/detail.html.twig', [
            'car' => $car,
            'store' => $storeExport,
            'stores' => $stores,
            'params' => $params,
            'company' => $compagny,
            'form' => $form->createView(),
        ]);
    }
}
