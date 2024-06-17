<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RecipeController extends AbstractController
{
    #[Route('/recipe', name: 'app_recipe')]
    public function recipe(Request $request, EntityManagerInterface $em): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
             $recipe->setCreatAt(new \DateTimeImmutable());
            $em->persist($recipe);
            $em->flush();
           
             $this->addFlash('message', 'Recipe added with success');
            return $this->redirectToRoute('app_recipe');
           
        }
        return $this->render('recipe/new.html.twig', [
            'newrecipeform' => $form,
        ]);
    }

}