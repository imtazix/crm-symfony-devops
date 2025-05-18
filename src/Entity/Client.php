<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column]
    private string $nomGerant;

    #[ORM\Column]
    private string $raisonSociale;

    #[ORM\Column]
    private string $telephone;

    #[ORM\Column]
    private string $adresse;

    #[ORM\Column]
    private string $ville;

    #[ORM\Column]
    private string $pays;

    #[ORM\ManyToOne(inversedBy: 'clients')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Facture::class, cascade: ['remove'], orphanRemoval: true)]
    private Collection $factures;

    public function __construct()
    {
        $this->factures = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getNomGerant(): string { return $this->nomGerant; }
    public function setNomGerant(string $nom): self { $this->nomGerant = $nom; return $this; }

    public function getRaisonSociale(): string { return $this->raisonSociale; }
    public function setRaisonSociale(string $raison): self { $this->raisonSociale = $raison; return $this; }

    public function getTelephone(): string { return $this->telephone; }
    public function setTelephone(string $tel): self { $this->telephone = $tel; return $this; }

    public function getAdresse(): string { return $this->adresse; }
    public function setAdresse(string $adresse): self { $this->adresse = $adresse; return $this; }

    public function getVille(): string { return $this->ville; }
    public function setVille(string $ville): self { $this->ville = $ville; return $this; }

    public function getPays(): string { return $this->pays; }
    public function setPays(string $pays): self { $this->pays = $pays; return $this; }

    public function getUser(): ?User { return $this->user; }
    public function setUser(?User $user): self { $this->user = $user; return $this; }

    public function getFactures(): Collection { return $this->factures; }
}
