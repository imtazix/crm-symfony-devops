<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class FactureDto
{
    #[Assert\NotBlank(message: 'Le numéro de facture est obligatoire.')]
    public string $numero;

    #[Assert\NotBlank(message: 'La date est obligatoire.')]
    #[Assert\Type(type: \DateTimeInterface::class, message: 'La date doit être au format valide.')]
    public \DateTimeInterface $date;

    #[Assert\NotBlank(message: 'Le montant est obligatoire.')]
    #[Assert\Type(type: 'float', message: 'Le montant doit être un nombre.')]
    public float $montant;

    #[Assert\NotBlank(message: 'L\'état est obligatoire.')]
    #[Assert\Length(max: 50, maxMessage: 'L\'état ne peut pas dépasser 50 caractères.')]
    public string $etat;

    public ?string $note = null;
}
