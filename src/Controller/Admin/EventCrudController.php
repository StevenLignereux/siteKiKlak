<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $imageFile = ImageField::new('image', 'Image')
            ->setUploadDir('public/images/uploads/events');

        $image = ImageField::new('image', 'Image')->setBasePath('/images/uploads/events');

        $fields = [
            IntegerField::new('id', 'ID')->onlyOnIndex(),
            TextField::new('name', 'nom'),
            TextField::new('place', 'lieu'),
            DateField::new('BeginAt', 'date de l\'événement')
        ];

        if ($pageName === Crud::PAGE_INDEX || $pageName === Crud::PAGE_DETAIL) {
            $fields[] = $image;
        } else {
            $fields[] = $imageFile;
        }

        return $fields;
    }

}
