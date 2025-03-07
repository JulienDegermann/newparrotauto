<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Traits\Pages\DatasTrait;
use App\Repository\StoreRepository;
use App\Repository\CommentRepository;
use App\Repository\CompanyRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    use DatasTrait;

    #[Route('/', name: 'app_home')]
    public function index(
        Request $request,
        CommentRepository $commentRepository,
        StoreRepository $storeRepository,
        SerializerInterface $serializer,
        CompanyRepository $companyRepository
    ): Response {

        $datas = $this->getDatas($request, $storeRepository, $companyRepository, $serializer);
        $storeExport = $datas['storeExport'];
        $stores = $datas['allStores'];
        $params = $datas['params'];
        $compagny = $datas['company'];

        // get datas from database (company and stores)
        $comments = $commentRepository->findApprovedComments();

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

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentRepository->save($comment);

            $this->addFlash('success', 'Votre commentaire a bien été envoyé et sera publié après validation.');
            
            return $this->redirectToRoute('app_home');
        }
        
        $this->addFlash('success', 'Votre commentaire a bien été envoyé sera publié après validation.');
        return $this->render('home/index.html.twig', [
            'comments' => $comments,
            'services' => $services,
            'comments' => $comments,
            'stores' => $stores,
            'store' => $storeExport,
            'params' => $params,
            'company' => $compagny,
            'form' => $form->createView(),
        ]);
    }
}
