<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');

        for ($nbPosts = 1; $nbPosts <= 50; $nbPosts++){
            $post = new Post();
            $post->setTitle($faker->jobTitle);
            $post->setContent($faker->text($maxNbChars = 10000));
            $manager->persist($post);
        }


        $manager->flush();
    }
}
