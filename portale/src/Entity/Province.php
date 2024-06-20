<?php

namespace App\Entity;

use App\Repository\ProvinceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProvinceRepository::class)]
class Province
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Column(length: 2)]
    private ?string $sigla = null;

    #[ORM\OneToMany(targetEntity: Cap::class, mappedBy: 'sigla_provincia')]
    private Collection $caps;

    public function __construct()
    {
        $this->caps = new ArrayCollection();
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

    public function getSigla(): ?string
    {
        return $this->sigla;
    }

    public function setSigla(string $sigla): static
    {
        $this->sigla = $sigla;

        return $this;
    }

    /**
     * @return Collection<int, Cap>
     */
    public function getCaps(): Collection
    {
        return $this->caps;
    }

    public function addCap(Cap $cap): static
    {
        if (!$this->caps->contains($cap)) {
            $this->caps->add($cap);
            $cap->setSiglaProvincia($this);
        }

        return $this;
    }

    public function removeCap(Cap $cap): static
    {
        if ($this->caps->removeElement($cap)) {
            // set the owning side to null (unless already changed)
            if ($cap->getSiglaProvincia() === $this) {
                $cap->setSiglaProvincia(null);
            }
        }

        return $this;
    }
}
