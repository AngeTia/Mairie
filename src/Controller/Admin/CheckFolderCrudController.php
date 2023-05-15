<?php

namespace App\Controller\Admin;

use App\Entity\CheckFolder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CheckFolderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CheckFolder::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
