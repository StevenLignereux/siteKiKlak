<?php

namespace App\DataFixtures;



use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

/**
 * Class PostFixtures
 * @package App\DataFixtures
 */
class PostFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for($nbAnnonces = 1; $nbAnnonces <= 100; $nbAnnonces++){
            $user = $this->getReference('user_'. $faker->numberBetween(1, 30));
            $category = $this->getReference('category_'. $faker->numberBetween(1, 4));

            $post = new Post();
            $post->setUser($user);
            $post->setCategory($category);
            $post->setTitle($faker->realText(25));
            $post->setContent($faker->realText(400));


            $manager->persist($post);
        }
        $manager->flush();
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [
            CategoriesFixtures::class,
            UserFixtures::class
        ];
    }
}