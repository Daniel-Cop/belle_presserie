<?php

namespace App\Controller\Admin;

use App\Entity\Employee;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EmployeeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Employee::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('email'),
            ArrayField::new('roles'),
            TextField::new('password')->onlyOnForms(),
            DateField::new('createdAt'), // maybe DateTimeField ?
            TextField::new('firstName'),
            TextField::new('lastName'),
            DateField::new('birthday'),
            TextField::new('address'),
            AssociationField::new('city')->autocomplete(),
            TextField::new('employeeNumber'),
            AssociationField::new('articles')->autocomplete(),
        ];
    }

}
