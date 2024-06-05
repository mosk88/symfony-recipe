<?php

namespace App\Controller;


use App\Entity\NewsletterEmail;
use App\Form\NewsletterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NewsletterController extends AbstractController
{
    #[Route('/newsletter', name: 'app_newsletter')]
    public function subscribe(Request $request, EntityManagerInterface $em): Response
    {
        $newsletter = new NewsletterEmail();
        $form = $this->createForm(NewsletterType::class, $newsletter);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($newsletter);
            $em->flush();
            return $this->redirectToRoute('newsletter_thanks');
        }
        return $this->render('newsletter/index.html.twig', [
            'controller_name' => 'NewsletterController'
        ]);
    }
    // #[Route('/newsletter/thanks', name:'newsletter_thanks')]

}
