<?php

namespace App\Controller\Admin;

use App\Entity\Equipment;
use App\Traits\Admin\CrudTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EquipmentCrudController extends AbstractCrudController
{
    use CrudTrait;
    
    public static function getEntityFqcn(): string
    {
        return Equipment::class;
    }

    public function configureActions(Actions $action): Actions
    {
        $actions = $this->configureDefaultActions($action);
        return $actions;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Équipements')
            ->setEntityLabelInSingular('Équipement');
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('text', 'Nom de l\'équipement'),
            AssociationField::new('cars', 'Véhicules')->autocomplete(),
        ];
    }
    
}
