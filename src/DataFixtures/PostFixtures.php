<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PostFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($nbPosts = 1; $nbPosts <= 30; $nbPosts++) {
            $user = $this->getReference('user_' . $faker->numberBetween(1, 5));
            $category = $this->getReference('category_' . $faker->numberBetween(1, 4));

            $post = new Post();
            $post->setUser($user)
                ->setCategory($category)
                ->setTitle($faker->realText(25))
                ->setContent($faker->realText(400));

            $manager->persist($post);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
          CategoriesFixtures::class,
          UserFixtures::class
        ];
    }
}
