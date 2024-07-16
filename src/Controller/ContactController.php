<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\ContactType;
use App\Repository\UserRepository;
use App\Repository\StoreRepository;
use App\Repository\CompanyRepository;
use App\Repository\MessageRepository;
use App\Traits\Pages\DatasTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ContactController extends AbstractController
{
    use DatasTrait;

    #[Route('/contact', name: 'app_contact')]
    public function index(
        Request $request,
        CompanyRepository $companyRepository,
        StoreRepository $storeRepository,
        UserRepository $userRepository,
        MessageRepository $messageRepository,
        SerializerInterface $serializer
    ): Response | JsonResponse {

        $datas = $this->getDatas($request, $storeRepository, $companyRepository, $serializer);
        if ($request->query->get('store')) {
            return $datas;
        }
        $storeExport = $datas['storeExport'];
        $allStores = $datas['allStores'];
        $params = $datas['params'];
        $compagny = $datas['company'];

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
            $messageRepository->save($message);

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
