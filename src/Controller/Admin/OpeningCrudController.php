<?php

namespace App\Controller\Admin;

use App\Entity\Opening;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OpeningCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Opening::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            ChoiceField::new('day', 'Jour')
                ->setChoices([
                    'Lundi' => 'Lundi',
                    'Mardi' => 'Mardi',
                    'Mercredi' => 'Mercredi',
                    'Jeudi' => 'Jeudi',
                    'Vendredi' => 'Vendredi',
                    'Samedi' => 'Samedi',
                    'Dimanche' => 'Dimanche',
                ]),
            TimeField::new('open', 'Ouverture'),
            TimeField::new('close', 'Fermeture'),
        ];
    }
}
