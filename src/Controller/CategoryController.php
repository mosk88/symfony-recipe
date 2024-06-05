<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'list_category')]
    public function list(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('category/list.html.twig', [
            'controller_name' => 'CategoryController',
            'categories' => $categories
        ]);
    }
    #[Route('/category/{name}', name: 'category_item')]
    public function item(Category $category): Response
    {
        return $this->render('category/item.html.twig', [
            'category' => $category,

        ]);
    }
    #[Route('/recipes', name: 'recipes_list')]
    public function recipes(RecipeRepository $recipeRepository): Response
    {
        $recipes = $recipeRepository->findAll();
        return $this->render('index/recipes.html.twig', [
            'recipes' => $recipes
        ]);
    }
}