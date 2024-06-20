<?php

namespace App\Entity;

use App\Repository\AgentiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgentiRepository::class)]
class Agenti
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Column(length: 255)]
    private ?string $cognome = null;

    #[ORM\OneToMany(targetEntity: Clienti::class, mappedBy: 'id_agente')]
    private Collection $clienti;

    #[ORM\ManyToMany(targetEntity: AgentiCap::class, mappedBy: 'id_agente')]
    private Collection $agentiCaps;

    public function __construct()
    {
        $this->clienti = new ArrayCollection();
        $this->agentiCaps = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    public function getCognome(): ?string
    {
        return $this->cognome;
    }

    public function setCognome(string $cognome): static
    {
        $this->cognome = $cognome;

        return $this;
    }

    /**
     * @return Collection<int, Clienti>
     */
    public function getClienti(): Collection
    {
        return $this->clienti;
    }

    public function addClienti(Clienti $clienti): static
    {
        if (!$this->clienti->contains($clienti)) {
            $this->clienti->add($clienti);
            $clienti->setIdAgente($this);
        }

        return $this;
    }

    public function removeClienti(Clienti $clienti): static
    {
        if ($this->clienti->removeElement($clienti)) {
            // set the owning side to null (unless already changed)
            if ($clienti->getIdAgente() === $this) {
                $clienti->setIdAgente(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AgentiCap>
     */
    public function getAgentiCaps(): Collection
    {
        return $this->agentiCaps;
    }

    public function addAgentiCap(AgentiCap $agentiCap): static
    {
        if (!$this->agentiCaps->contains($agentiCap)) {
            $this->agentiCaps->add($agentiCap);
            $agentiCap->addIdAgente($this);
        }

        return $this;
    }

    public function removeAgentiCap(AgentiCap $agentiCap): static
    {
        if ($this->agentiCaps->removeElement($agentiCap)) {
            $agentiCap->removeIdAgente($this);
        }

        return $this;
    }
}
