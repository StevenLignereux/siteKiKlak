<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class CategoriesFixtures
 * @package App\DataFixtures
 */
class CategoriesFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $categories = [
            1 => [
                'name' => 'Articles'
            ],
            2 => [
                'name' => 'Evénements'
            ],
            3 => [
                'name' => 'Billets'
            ],
            4 => [
                'name' => 'Avis'
            ]
        ];

        foreach ($categories as $key => $value) {
            $categories = new Category();
            $categories->setName($value['name']);
            $manager->persist($categories);
        }

        $manager->flush();
    }
}
