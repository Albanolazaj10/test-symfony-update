<?php

namespace App\Controller\Admin;

use App\Entity\OrderLine;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class OrderLineCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OrderLine::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('product'),
            IntegerField::new('count'),
            MoneyField::new('totalPrice')->setCurrency('EUR'),
            MoneyField::new('discount')->setCurrency('EUR'),
            MoneyField::new('payablePrice')->setCurrency('EUR'),
            TextField::new('orderLine'),
        ];
    }
    
}
