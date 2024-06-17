<?php

namespace App\Mailer;
use App\Entity\NewsletterEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
 
class MailSendConfirmation{

public function __construct(private MailerInterface $mailer, private string $adminEmail)
{

}


    public function sendConfirmationEmail(NewsletterEmail $newEmail ){
        $email = (new Email())
            ->from($this->adminEmail)
            ->to($newEmail->getEmail())
            ->subject("inscription")
            ->text("bienvenu au club");
            $this->mailer->send($email);
        
    }
}