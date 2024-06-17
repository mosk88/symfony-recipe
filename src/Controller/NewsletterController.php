<?php

namespace App\Controller;


use App\Entity\NewsletterEmail;
use App\Form\NewsletterType;
use App\Mailer\MailSendConfirmation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NewsletterController extends AbstractController
{

    #[Route('/newsletter', name: 'app_newsletter')]
    public function subscribe(Request $request, EntityManagerInterface $em,MailSendConfirmation $mailSendConfirmation): Response
    {
        $newsletter = new NewsletterEmail();
        $form = $this->createForm(NewsletterType::class, $newsletter);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($newsletter);
            $em->flush();
            $mailSendConfirmation->sendConfirmationEmail($newsletter);
            $this->addFlash('message','subscribe succesful');
            return $this->redirectToRoute('app_newsletter');
        }
        return $this->render('newsletter/subscribe.html.twig', [
            'newsletterform' => $form
        ]);
    }
 
    

}
