<?php

namespace App\Controller\Admin;

use App\Entity\ProductRestaurant;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class ProductRestaurantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductRestaurant::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Relations'),
            IdField::new('id')->setDisabled(),
            AssociationField::new('product'),
            AssociationField::new('restaurant'),
            FormField::addTab('Price and stock'),
            NumberField::new('price')->setNumDecimals(2),
            IntegerField::new('stock')
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('product')
            ->add('restaurant')
            ->add('price');
    }
}
