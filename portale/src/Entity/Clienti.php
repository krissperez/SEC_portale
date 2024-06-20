<?php

namespace App\Entity;

use App\Repository\ClientiRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientiRepository::class)]
class Clienti
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $ragione_sociale = null;

    #[ORM\Column(length: 11)]
    private ?string $partita_IVA = null;

    #[ORM\Column(length: 255)]
    private ?string $indirizzo = null;

    #[ORM\Column(length: 255)]
    private ?string $provincia = null;

    #[ORM\ManyToOne(inversedBy: 'clienti')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cap $cap = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $pec = null;

    #[ORM\Column(length: 255)]
    private ?string $telefono = null;

    #[ORM\Column(length: 255)]
    private ?string $settore_attivita = null;

    #[ORM\ManyToOne(inversedBy: 'clienti')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Agenti $id_agente = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $data_acquisizione = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRagioneSociale(): ?string
    {
        return $this->ragione_sociale;
    }

    public function setRagioneSociale(string $ragione_sociale): static
    {
        $this->ragione_sociale = $ragione_sociale;

        return $this;
    }

    public function getPartitaIVA(): ?string
    {
        return $this->partita_IVA;
    }

    public function setPartitaIVA(string $partita_IVA): static
    {
        $this->partita_IVA = $partita_IVA;

        return $this;
    }

    public function getIndirizzo(): ?string
    {
        return $this->indirizzo;
    }

    public function setIndirizzo(string $indirizzo): static
    {
        $this->indirizzo = $indirizzo;

        return $this;
    }

    public function getProvincia(): ?string
    {
        return $this->provincia;
    }

    public function setProvincia(string $provincia): static
    {
        $this->provincia = $provincia;

        return $this;
    }

    public function getCap(): ?Cap
    {
        return $this->cap;
    }

    public function setCap(?Cap $cap): static
    {
        $this->cap = $cap;

        return $this;
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

    public function getPec(): ?string
    {
        return $this->pec;
    }

    public function setPec(string $pec): static
    {
        $this->pec = $pec;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): static
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getSettoreAttivita(): ?string
    {
        return $this->settore_attivita;
    }

    public function setSettoreAttivita(string $settore_attivita): static
    {
        $this->settore_attivita = $settore_attivita;

        return $this;
    }

    public function getIdAgente(): ?Agenti
    {
        return $this->id_agente;
    }

    public function setIdAgente(?Agenti $id_agente): static
    {
        $this->id_agente = $id_agente;

        return $this;
    }

    public function getDataAcquisizione(): ?\DateTimeInterface
    {
        return $this->data_acquisizione;
    }

    public function setDataAcquisizione(\DateTimeInterface $data_acquisizione): static
    {
        $this->data_acquisizione = $data_acquisizione;

        return $this;
    }
}
