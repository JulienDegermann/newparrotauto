<?php

namespace App\Controller\Admin;

use App\Entity\Car;
use App\Traits\Admin\CrudTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CarCrudController extends AbstractCrudController
{
    use CrudTrait;

    public static function getEntityFqcn(): string
    {
        return Car::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Véhicules')
            ->setEntityLabelInSingular('Véhicule');
    }

    public function configureActions(Actions $action): Actions
    {
        $actions = $this->configureDefaultActions($action);

        return $actions;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('model', 'Modèle'),
            DateField::new('circulationDate', 'Mise en circulation'),
            AssociationField::new('energy', 'Carburant'),
            AssociationField::new('equipments', 'Équipements')->autocomplete()->hideOnIndex(),
            NumberField::new('mileage', 'Kilométrage (kms)'),
            IntegerField::new('price', 'Prix (€)'),
            TextareaField::new('text', 'Description')->hideOnIndex(),
            AssociationField::new('author', 'Auteur')->hideOnIndex(),
            DateTimeField::new('createdAt', 'Créé le')->hideOnForm()->hideOnIndex(),
            DateTimeField::new('updatedAt', 'Modifié le')->hideOnForm(),
            CollectionField::new('images', 'Images')
                ->useEntryCrudForm()
        ];
    }
}
