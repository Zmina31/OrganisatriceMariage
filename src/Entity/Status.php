<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
class Status
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $etat = null;

    #[ORM\OneToMany(mappedBy: 'status', targetEntity: Temoignage::class)]
    private Collection $temoignages;

    public function __construct()
    {
        $this->temoignages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection<int, Temoignage>
     */
    public function getTemoignages(): Collection
    {
        return $this->temoignages;
    }

    public function addTemoignage(Temoignage $temoignage): static
    {
        if (!$this->temoignages->contains($temoignage)) {
            $this->temoignages->add($temoignage);
            $temoignage->setStatus($this);
        }

        return $this;
    }

    public function removeTemoignage(Temoignage $temoignage): static
    {
        if ($this->temoignages->removeElement($temoignage)) {
            // set the owning side to null (unless already changed)
            if ($temoignage->getStatus() === $this) {
                $temoignage->setStatus(null);
            }
        }

        return $this;
    }
}
