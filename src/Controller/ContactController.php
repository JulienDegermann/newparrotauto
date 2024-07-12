<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\ContactType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use App\Repository\UserRepository;
use App\Repository\StoreRepository;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(
        Request $request,
        CompanyRepository $companyRepository,
        StoreRepository $storeRepository,
        UserRepository $userRepository,
        EntityManagerInterface $em,
        SerializerInterface $serializer
    ): Response {

        // get datas from database (company and stores)
        $compagny = $companyRepository->findAll()[0];

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
            if ($store) {
                $data = $serializer->serialize($storeExport, 'json', ['groups' => 'storeUpdate']);
                return new JsonResponse($data, 200, ['Content-Type' => 'application/json'], true);
            }
        }

        $message = new Message();
        $form = $this->createForm(ContactType::class, $message);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($form->get('author')->get('email')->getData());
            $user = $userRepository->findOneBy(['email' => $form->get('author')->get('email')->getData()]);
            if ($user) {
                $author = $user;
            } else {
                $author = $form->get('author')->getData();
            }
            $message = $form->getData();
            $message->setAuthor($author);
            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('Contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'form' => $form->createView(),
            'company' => $compagny,
            'store' => $storeExport,
            'stores' => $allStores,
            'params' => $params
        ]);
    }
}
