<?php

namespace App\Controller\Admin;

use App\Entity\Model;
use App\Traits\Admin\CrudTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ModelCrudController extends AbstractCrudController
{
    use CrudTrait;

    public static function getEntityFqcn(): string
    {
        return Model::class;
    }

    public function configureActions(Actions $action): Actions
    {
        $actions = $this->configureDefaultActions($action);
        return $actions;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Modèles')
            ->setEntityLabelInSingular('Modèle');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom du modèle'),
        ];
    }
}
