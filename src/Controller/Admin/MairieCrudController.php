<?php

namespace App\Controller\Admin;

use App\Entity\Mairie;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MairieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Mairie::class;
    }

    
    // public function configureFields(string $pageName): iterable
    // {
    //     return [
    //         IdField::new('id'),
    //         TextField::new('title'),
    //         TextEditorField::new('description'),
    //     ];
    // }
    
}
