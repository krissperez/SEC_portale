<?php

namespace App\Entity;

use App\Repository\AgentiCapRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgentiCapRepository::class)]
class AgentiCap
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Agenti::class, inversedBy: 'agentiCaps')]
    private Collection $id_agente;

    #[ORM\ManyToMany(targetEntity: Cap::class, inversedBy: 'agentiCaps')]
    private Collection $id_cap;

    public function __construct()
    {
        $this->id_agente = new ArrayCollection();
        $this->id_cap = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Agenti>
     */
    public function getIdAgente(): Collection
    {
        return $this->id_agente;
    }

    public function addIdAgente(Agenti $idAgente): static
    {
        if (!$this->id_agente->contains($idAgente)) {
            $this->id_agente->add($idAgente);
        }

        return $this;
    }

    public function removeIdAgente(Agenti $idAgente): static
    {
        $this->id_agente->removeElement($idAgente);

        return $this;
    }

    /**
     * @return Collection<int, Cap>
     */
    public function getIdCap(): Collection
    {
        return $this->id_cap;
    }

    public function addIdCap(Cap $idCap): static
    {
        if (!$this->id_cap->contains($idCap)) {
            $this->id_cap->add($idCap);
        }

        return $this;
    }

    public function removeIdCap(Cap $idCap): static
    {
        $this->id_cap->removeElement($idCap);

        return $this;
    }
}
