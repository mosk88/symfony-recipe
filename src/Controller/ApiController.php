<?php

namespace App\Controller;


use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/api')]
class ApiController extends AbstractController
{
    #[Route('/recipes', name: 'api_recipes')]
    public function recipes(RecipeRepository $recipeRepository): JsonResponse
    {
        $recipes = $recipeRepository->findAll();
        return $this->json(
        $recipes,
        context: ['groups' => ['recipes:read'], 
    ]);
    }
    #[Route(path:'/recipes/{id}', name:'api_recipe_item')]
    public function recipe(RecipeRepository $recipeRepository,int $id): JsonResponse
    {
        return $this->json(
            $recipeRepository->findById($id),
            context: ['groups' => ['recipe:read:item'],
            ]);
    }
}
