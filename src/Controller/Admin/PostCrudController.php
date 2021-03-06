<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }



    public function configureFields(string $pageName): iterable
    {
        $imageFile = ImageField::new('image', 'Image')
            ->setUploadDir('public/images/uploads');

        $image = ImageField::new('image', 'Image')->setBasePath('/images/uploads');

        $fields = [
            IntegerField::new('id', 'ID')->onlyOnIndex(),
            TextField::new('title', 'titre'),
            TextEditorField::new('content', 'contenu'),
            AssociationField::new('category', 'catégorie'),
            AssociationField::new('user', 'auteur'),
        ];

        if ($pageName === Crud::PAGE_INDEX || $pageName === Crud::PAGE_DETAIL) {
            $fields[] = $image;
        } else {
            $fields[] = $imageFile;
        }

        return $fields;
    }

}
