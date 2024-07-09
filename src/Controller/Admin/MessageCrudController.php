<?php

namespace App\Controller\Admin;

use App\Entity\Message;
use App\Traits\Admin\CrudTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MessageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Message::class;
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
            ->setSearchFields([
                'name',
                'email',
                'phone',
                'zipCode',
                'energy',
                'created_at',
                'updated_at'
            ])
            ->setEntityLabelInPlural('Messages')
            ->setEntityLabelInSingular('Message');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Titre'),
            TextareaField::new('text', 'Contenu'),
            AssociationField::new('author', 'Auteur')->hideOnForm(),

        ];
    }
}
