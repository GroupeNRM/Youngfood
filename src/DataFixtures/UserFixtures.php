<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Food;
use App\Entity\User;
use App\Entity\Child;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * L'encoder de mots de passe
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        
        $this->encoder = $encoder;

    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $admin = new USer();

        $adminHash = $this->encoder->encodepassword($admin, 'aM7KdQa77');

        $admin  ->setEmail('admin@youngfood.local')
                ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
                ->setPassword($adminHash)
                ->setFirstname('John')
                ->setLastname('Doe')
                ->setGender('M')
                ->setRegisteredAt(new \DateTime('now'))
                
                ;
                
                $manager->persist($admin);

                
            
                for ($u = 1; $u < 20; $u++) { 
                    
                    $gender = $faker->randomElements(["M", "F"]); 
                
                    $gender = implode(" ", $gender);

                    $user = new User();

                    $hash = $this->encoder->encodePassword($user, "password");

                    $user   ->SetEmail($faker->unique()->safeEmail)
                            ->setRoles(['ROLE_USER'])
                            ->setPassword($hash)
                            ->setFirstname($faker->firstName($gender))
                            ->setLastname($faker->lastName($gender))
                            ->setGender($gender)
                            ->setRegisteredAt(new \DateTime('now'))
                            
                            ;

                    $manager->persist($user);



                    for ($c = 1 ; $c < mt_rand(1, 5); $c++) { 

                        $child = (new Child())
                                ->setNom($faker->lastName())
                                ->setPrenom($faker->firstName())
                                ->setDateNaissance($faker->dateTimeBetween($startDate = '-20 years', $endDate = 'now', $timezone = null))
                                ->setDateInscription((new \DateTime('now'))->format('Y-m-d'))
                                ->setUser($user)
                                ;
                                
                        $manager->persist($child);
                    }
                }

        $manager->flush();
    }
}
