<?php

namespace App\Traits\Pages;

use App\Repository\CompanyRepository;
use App\Repository\StoreRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

trait DatasTrait
{
  /**
   * Get the store opening hours
   * @param Request $request the request object
   * @param StoreRepository $storeRepository for get datas from database
   * @param CompanyRepository $companyRepository for get datas from database
   * @param SerializerInterface $serializer for format datas
   * @return JsonResponse|void return JSON if JS fetch or datas for the view
   */
  public function getDatas(
    Request $request,
    StoreRepository $storeRepository,
    CompanyRepository $companyRepository,
    SerializerInterface $serializer
  ): JsonResponse | array {

    $company = $companyRepository->findAll()[0];

    // find a param in url
    $params = $request->query->get('store');

    // if(!$params) {
    //     $params = 'toulouse';
    // }
    $store = $storeRepository->findOneBy(['city' => $params ?? 'Sulniac']);;
    $allStores = $storeRepository->findAll();

    // format data to be used in the view
    $storeExport = [];
    $opens = $store->getOpenings();
    $openSorted = [];
    foreach ($opens as $open) {
      if (!array_key_exists($open->getDay(), $openSorted)) {
        $openSorted[$open->getDay()] = [];
      }
      $openSorted[$open->getDay()][] = [$open->getOpen(), $open->getClose()];
    }
    $opens = $openSorted;
    $storeExport['openings'] = $opens;
    $storeExport['address'] = $store->getAddress();
    $storeExport['phone'] = $store->getPhone();
    $storeExport['city'] = $store->getCity();

    if ($params) {
      if ($storeExport) {
        $data = $serializer->serialize($storeExport, 'json', ['groups' => 'storeUpdate']);
        return new JsonResponse($data, 200, ['Content-Type' => 'application/json'], true);
      }
    }

    $datas = [
      'params' =>  $params,
      'company' => $company,
      'allStores' => $allStores,
      'storeExport' => $storeExport
    ];
    return $datas;
  }
}
