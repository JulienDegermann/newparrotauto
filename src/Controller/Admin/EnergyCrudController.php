<?php

namespace App\Controller\Admin;

use App\Entity\Energy;
use App\Traits\Admin\CrudTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EnergyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Energy::class;
    }

    use CrudTrait;
    public function configureActions(Actions $action): Actions
    {
        $actions = $this->configureDefaultActions($action);
        return $actions;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Carburants')
            ->setEntityLabelInSingular('Carburant');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Carburant'),
        ];
    }

}
