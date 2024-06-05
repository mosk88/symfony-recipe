<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Recipe;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
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
             ->setVisible($faker->boolean())
             ->setCategory($faker->randomElement($list));
             $manager->persist($recipe);
    
       }
$manager->flush();


        
    }
}
