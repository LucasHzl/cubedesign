<?php

namespace App\Controller\Admin;

use App\Entity\Products;
use App\Entity\Categories;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Products::class;

    }

    
    public function configureFields(string $pageName): iterable
    {
        return [

            TextField::new('title'),
            IntegerField::new('price'),
            IntegerField::new('stock'),
            AssociationField::new('category'),
            TextEditorField::new('description'),
            TextField::new('imageFile')->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('imageName')->setBasePath('/assets/images/products')->setUploadDir('/public')->onlyOnIndex()
        ];
    }
    
}
