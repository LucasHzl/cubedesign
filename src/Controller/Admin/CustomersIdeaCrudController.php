<?php

namespace App\Controller\Admin;

use App\Entity\CustomersIdea;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CustomersIdeaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CustomersIdea::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('first_name'),
            TextField::new('last_name'),
            TextField::new('email'),
            TextField::new('message'),
        ];
    }
}
