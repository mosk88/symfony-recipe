<?php

namespace App\Entity;

use App\Repository\NewsletterEmailRepository;
use App\Validator\IsNotSpam;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: NewsletterEmailRepository::class)]
#[UniqueEntity("email",message:"l'email existe deja")]
class NewsletterEmail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\Email(message: "l'email n'est pas valide")]
    #[Assert\NotBlank(message: "l'email est obligatoire")]
    #[IsNotSpam]
    private ?string $email = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }
}
