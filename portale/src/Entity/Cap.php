<?php

namespace App\Entity;

use App\Repository\CapRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CapRepository::class)]
class Cap
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $codice = null;

    #[ORM\Column(length: 255)]
    private ?string $comune = null;

    #[ORM\Column(length: 2)]
    private ?string $sigla_provincia = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodice(): ?string
    {
        return $this->codice;
    }

    public function setCodice(string $codice): static
    {
        $this->codice = $codice;

        return $this;
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

    public function getSiglaProvincia(): ?string
    {
        return $this->sigla_provincia;
    }

    public function setSiglaProvincia(string $sigla_provincia): static
    {
        $this->sigla_provincia = $sigla_provincia;

        return $this;
    }
}
