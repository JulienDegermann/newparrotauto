<?php

namespace App\Controller\Admin;

use App\Entity\Brand;
use App\Traits\Admin\CrudTrait;
use Doctrine\Common\Collections\Collection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BrandCrudController extends AbstractCrudController
{
    use CrudTrait;

    public static function getEntityFqcn(): string
    {
        return Brand::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Marques')
            ->setEntityLabelInSingular('Marque');
    }

    public function configureActions(Actions $action): Actions
    {
        $actions = $this->configureDefaultActions($action);
        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom de la marque'),
            CollectionField::new('models', 'Modèles')->useEntryCrudForm(),
        ];
    }
}
