<?php

namespace App\DataFixtures;

use App\Entity\ApiToken;
use App\Entity\Category;
use App\Entity\Recipe;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Command\UserPasswordHashCommand;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passhasher)
    { 

    }
    private const CATEGORIES  = ['Recette Marocainne','Recette Française ','Recette Japonaise','Recette Libyanne','Recette Berbare'];
    private const ARTICLES_NB = 10;
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');
        $list = [];
        foreach (self::CATEGORIES as $namecategory) {
            $category = new Category();
            $category
                ->setName($namecategory);
            $manager->persist($category);
            $list[] = $category;
            $manager->persist($category);
        }
       for($i = 0; $i < self::ARTICLES_NB; $i++) {
           $recipe = new Recipe();
        $recipe
             ->setTitle($faker->words(nb: $faker->numberBetween(1,3), asText: true))
             ->setContent($faker->realTextBetween(300, 500))
             ->setCreatAt(DateTimeImmutable::createFromMutable(object: $faker->dateTimeBetween(startDate:'-2 years')))
             ->setPicturefilename('IMG-20201211-WA0024-6672c25506229.jpg')
             ->setVisible($faker->boolean())
             ->setCategory($faker->randomElement($list));
             $manager->persist($recipe);
    
       }
        $admin = new User();
        $admin
            ->setEmail('admin@mos.com')
            ->setPassword('admin')
            ->setRoles(['ROLE_ADMIN']);
            $manager->persist($admin);

        $user = new User();
        $user
        ->setEmail('user@mos.com')    
        ->setPassword('user')
        ->setRoles(['ROLE_USER']);
        $manager->persist($user);

        $token = new ApiToken();
        $token->setToken('vxAj0MFsp0l5qB5C8D');

        $manager->persist($token);
        //envoyer les donnes vers BBD
        $manager->flush();



$manager->flush();


        
    }
}
