<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            DateField::new('createdAt', 'Créé le'),
            TextField::new('carrierName', 'Nom du transporteur'),
            TextField::new('delivery', 'Adresse de livraison'),
            MoneyField::new('carrierPrice', 'Prix du transporteur')->setCurrency('EUR')
        ];
    }
}
