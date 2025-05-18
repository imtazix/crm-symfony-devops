<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FactureRepository::class)]
class Facture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(unique: true)]
    private string $numero;

    #[ORM\Column(type: "date")]
    private \DateTimeInterface $date;

    #[ORM\Column(type: "float")]
    private float $montant;

    #[ORM\Column(length: 50)]
    private string $etat;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $note = null;

    #[ORM\ManyToOne(inversedBy: 'factures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client;

    public function getId(): ?int { return $this->id; }

    public function getNumero(): string { return $this->numero; }
    public function setNumero(string $numero): self { $this->numero = $numero; return $this; }

    public function getDate(): \DateTimeInterface { return $this->date; }
    public function setDate(\DateTimeInterface $date): self { $this->date = $date; return $this; }

    public function getMontant(): float { return $this->montant; }
    public function setMontant(float $montant): self { $this->montant = $montant; return $this; }

    public function getEtat(): string { return $this->etat; }
    public function setEtat(string $etat): self { $this->etat = $etat; return $this; }

    public function getNote(): ?string { return $this->note; }
    public function setNote(?string $note): self { $this->note = $note; return $this; }

    public function getClient(): ?Client { return $this->client; }
    public function setClient(?Client $client): self { $this->client = $client; return $this; }
}
