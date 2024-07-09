<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use App\Traits\Admin\CrudTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class CompanyCrudController extends AbstractCrudController
{
    use CrudTrait;

    public static function getEntityFqcn(): string
    {
        return Company::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['name', 'text'])
            ->setEntityLabelInSingular('Société')
            ->setPageTitle('index', 'Informations sur la société');
    }

    public function configureActions(Actions $action): Actions
    {
        $actions = $this->configureDefaultActions($action);
        $actions
            ->remove(Crud::PAGE_INDEX, 'new')
            ->remove(Crud::PAGE_INDEX, 'delete')
            ->remove(Crud::PAGE_DETAIL, 'delete');
        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom de la société'),
            TextareaField::new('text', 'Description'),
        ];
    }
}
