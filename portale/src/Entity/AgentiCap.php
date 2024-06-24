<?php

namespace App\Entity;

use App\Repository\AgentiCapRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgentiCapRepository::class)]
class AgentiCap
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_agente = null;

    #[ORM\Column(length: 255)]
    private ?string $codice_cap = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdAgente(): ?int
    {
        return $this->id_agente;
    }

    public function setIdAgente(int $id_agente): static
    {
        $this->id_agente = $id_agente;

        return $this;
    }

    public function getIdCap(): ?string
    {
        return $this->codice_cap;
    }

    public function setIdCap(string $codice_cap): static
    {
        $this->codice_cap = $codice_cap;

        return $this;
    }
}
