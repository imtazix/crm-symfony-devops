<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class ClientDto
{
    #[Assert\NotBlank]
    public string $nomGerant;

    #[Assert\NotBlank]
    public string $raisonSociale;

    #[Assert\NotBlank]
    public string $telephone;

    #[Assert\NotBlank]
    public string $adresse;

    #[Assert\NotBlank]
    public string $ville;

    #[Assert\NotBlank]
    public string $pays;
}
