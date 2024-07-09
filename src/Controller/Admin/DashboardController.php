<?php

namespace App\Controller\Admin;

use App\Entity\Car;
use App\Entity\User;
use App\Entity\Brand;
use App\Entity\Model;
use App\Entity\Store;
use App\Entity\Energy;
use App\Entity\Comment;
use App\Entity\Company;
use App\Entity\Message;
use App\Entity\Equipment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ParrotAuto');
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            ->setPaginatorPageSize(30)
            ->setSearchFields([
                'name',
                'text',
                'created_at',
                'updated_at'
            ])
            ->setDefaultSort(['createdAt' => 'DESC'])
            ->setDateFormat('dd/MM/yyyy')
            ->setTimeFormat('HH:mm:ss')
            ->setDateTimeFormat('dd/MM/yyyy HH:mm:ss')
            ->showEntityActionsInlined(true)
            ->setPageTitle('index', '%entity_label_plural%<small> [Liste]</small>')
            ->setPageTitle('detail', '%entity_label_singular%<small> #%entity_id% - Détails</small>')
            ->setPageTitle('edit', '%entity_label_singular%<small> #%entity_id% - Modification</small>')
            ->setPageTitle('new', '%entity_label_singular%<small> [Ajout]</small>')
            ->setTimezone('Europe/Paris');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Véhicules', 'fa fa-car');
        yield MenuItem::linkToCrud('Véhicules d\'occasion', 'fa fa-list', Car::class);
        yield MenuItem::linkToCrud('Modèles', 'fa fa-car', Brand::class);
        yield MenuItem::linkToCrud('Énergies', 'fa fa-gas-pump', Energy::class);
        yield MenuItem::linkToCrud('Équipements', 'fa fa-tools', Equipment::class);
        // ------------------------------------------------------------------------------------------------------------
        yield MenuItem::section('Entreprise', 'fa fa-building');
        yield MenuItem::linkToCrud('Informations générales', 'fa fa-info', Company::class);
        yield MenuItem::linkToCrud('Établissements', 'fa fa-location-dot', Store::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class);
        yield MenuItem::section('Communication', 'fa fa-envelope');
        yield MenuItem::linkToCrud('Messages', 'fa fa-message', Message::class);
        yield MenuItem::linkToCrud('Commentaires', 'fa fa-comment', Comment::class);
        // yield MenuItem::linkToCrud('Villes', 'fa fa-building', City::class);
        // yield MenuItem::linkToCrud('Horaires', 'fa fa-building', Opening::class);
    }
}
