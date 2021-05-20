<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use Doctrine\DBAL\Types\BooleanType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;
use App\Field\VichImageField;


class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return array(
            TextField::new('name'),
            SlugField::new('slug')->setTargetFieldName('name'),
            TextField::new('imageFile')->setFormType(VichImageType::class)->onlyWhenCreating(),
            ImageField::new('illustration')
                ->setBasePath('/uploads/images/')->onlyOnIndex(),
//                ->setUploadDir('public/uploads/'),
//                ->setUploadedFileNamePattern('[randomhash].[extension]')
//                ->setRequired(false),
            TextField::new('subtitle'),
            TextareaField::new('description'),
            MoneyField::new('price')->setCurrency('EUR'),
            BooleanField::new('online'),
            AssociationField::new('category')
        );
    }

}
