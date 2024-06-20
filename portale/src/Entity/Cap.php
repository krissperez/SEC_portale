<?php

namespace App\Entity;

use App\Repository\CapRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CapRepository::class)]
class Cap
{
    #[ORM\Id]
    #[ORM\Column]
    private ?string $id = null;

    #[ORM\Column(length: 255)]
    private ?string $comune = null;

    #[ORM\ManyToOne(inversedBy: 'caps')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Province $sigla_provincia = null;

    #[ORM\OneToMany(targetEntity: Clienti::class, mappedBy: 'cap')]
    private Collection $clienti;

    #[ORM\ManyToMany(targetEntity: AgentiCap::class, mappedBy: 'id_cap')]
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

    public function getComune(): ?string
    {
        return $this->comune;
    }

    public function setComune(string $comune): static
    {
        $this->comune = $comune;

        return $this;
    }

    public function getSiglaProvincia(): ?Province
    {
        return $this->sigla_provincia;
    }

    public function setSiglaProvincia(?Province $sigla_provincia): static
    {
        $this->sigla_provincia = $sigla_provincia;

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
            $clienti->setCap($this);
        }

        return $this;
    }

    public function removeClienti(Clienti $clienti): static
    {
        if ($this->clienti->removeElement($clienti)) {
            // set the owning side to null (unless already changed)
            if ($clienti->getCap() === $this) {
                $clienti->setCap(null);
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
            $agentiCap->addIdCap($this);
        }

        return $this;
    }

    public function removeAgentiCap(AgentiCap $agentiCap): static
    {
        if ($this->agentiCaps->removeElement($agentiCap)) {
            $agentiCap->removeIdCap($this);
        }

        return $this;
    }
}
