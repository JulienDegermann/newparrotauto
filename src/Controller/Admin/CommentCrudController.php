<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields([
                'name',
                'email',
                'created_at',
            ])
            ->setEntityLabelInPlural('Messages')
            ->setEntityLabelInSingular('Message');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            DateTimeField::new('createdAt', 'Créé le'),
            TextField::new('name', 'Auteur'),
            TextareaField::new('text', 'Commentaire'),
            BooleanField::new('published', 'Publié'),
            IntegerField::new('note', 'Note')
        ];
    }
}
