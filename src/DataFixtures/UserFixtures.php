<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserFixtures
 * @package App\DataFixtures
 */
class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($nbUsers = 1; $nbUsers <= 5; $nbUsers++){
            $user = new User();
            $user->setEmail($faker->email);

            if ($nbUsers === 1){
                $user->setRoles(['ROLE_ADMIN']);
            } else {
                $user->setRoles(['ROLE_USER']);
            }

            $user->setPassword($this->encoder->encodePassword($user, 'azerty'));
            $user->setName($faker->lastName);
            $user->setFirstname($faker->firstName);
            $user->setIsVerified($faker->numberBetween(0, 1));
            $manager->persist($user);

            $this->addReference('user_'. $nbUsers, $user);
        }

        $manager->flush();
    }
}
