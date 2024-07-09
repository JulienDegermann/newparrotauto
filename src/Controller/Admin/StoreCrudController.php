<?php

namespace App\Controller\Admin;

use App\Entity\Store;
use App\Traits\Admin\CrudTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class StoreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Store::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Établissements')
            ->setEntityLabelInSingular('Établissements');
    }

    use CrudTrait;
    public function configureActions(Actions $action): Actions
    {
        $actions = $this->configureDefaultActions($action);
        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('city', 'Ville'),
            TextField::new('address', 'Adresse'),
            TelephoneField::new('phone', 'Numéro de téléphone')
            ,
            AssociationField::new('company', 'Entreprise')->onlyOnForms(),
            CollectionField::new('openings', 'Horaires')
                ->useEntryCrudForm(OpeningCrudController::class)
                // ->onlyOnForms(),
        ];
    }
}
