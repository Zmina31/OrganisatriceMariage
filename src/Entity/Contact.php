<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column]
    private ?int $invite = null;

    #[ORM\Column(length: 255)]
    private ?string $destination = null;

    #[ORM\Column]
    private ?float $budget = null;

    #[ORM\Column(length: 255)]
    private ?string $precisions = null;


    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'prestation')]
    private ?Prestation $prestation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getInvite(): ?int
    {
        return $this->invite;
    }

    public function setInvite(int $invite): static
    {
        $this->invite = $invite;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): static
    {
        $this->destination = $destination;

        return $this;
    }

    public function getBudget(): ?float
    {
        return $this->budget;
    }

    public function setBudget(float $budget): static
    {
        $this->budget = $budget;

        return $this;
    }

    public function getPrecisions(): ?string
    {
        return $this->precisions;
    }

    public function setPrecisions(string $precisions): static
    {
        $this->precisions = $precisions;

        return $this;
    }


    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getPrestation(): ?Prestation
    {
        return $this->prestation;
    }

    public function setPrestation(?Prestation $prestation): static
    {
        $this->prestation = $prestation;

        return $this;
    }
}
