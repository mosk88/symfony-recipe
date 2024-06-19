<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class RecipeController extends AbstractController
{
    #[Route('/recipe', name: 'app_recipe')]
    public function recipe(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recipe->setCreatAt(new \DateTimeImmutable());
            /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $pictureFilename */
            $pictureFilename = $form->get('picturefilename')->getData();

            if ($pictureFilename) {
                $originalFilename = pathinfo($pictureFilename->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $filename = $safeFilename . '-' . uniqid() . '.' . $pictureFilename->guessExtension();
                try {
                    // À la manière de move_uploaded_file en PHP, on tente ici de déplacer le fichier
                    // de sa zone de transit à sa destination
                    // Cette méthode peut lancer des exceptions : on encadre donc l'appel par un bloc
                    // try...catch
                    $pictureFilename->move(
                        'uploads/recipe/',
                        $filename
                    );
                    // Si on n'est pas passé dans le catch, alors on peut enregistrer le nom du fichier
                    // dans la propriété profilePicFilename de l'utilisateur
                    $recipe->setPictureFilename($filename);
                } catch (FileException $e) {
                    $form->addError(new FormError("Erreur lors de l'upload du fichier"));
                }
                $em->persist($recipe);
                $em->flush();

                $this->addFlash('message', 'Recipe added with success');
                return $this->redirectToRoute('app_recipe');

            }
           
        }
        return $this->render('recipe/new.html.twig', [
            'newrecipeform' => $form,
        ]);
    }
}