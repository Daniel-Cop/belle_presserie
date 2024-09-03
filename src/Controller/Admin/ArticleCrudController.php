<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('ID'),
            NumberField::new('Price'),
            AssociationField::new('service')->autocomplete(),
            AssociationField::new('item')->autocomplete(),
            AssociationField::new('status')->autocomplete(),
            AssociationField::new('material')->autocomplete(),
            AssociationField::new('clientOrder')->autocomplete(),
            AssociationField::new('employee')->autocomplete(),
        ];
    }

}
