<?php

namespace App\Service;
use App\Dto\FactureDto;
use App\Entity\Facture;

interface FactureServiceInterface
{
    public function createFacture(int $clientId, FactureDto $dto): Facture;

    public function updateFacture(int $factureId, FactureDto $dto): Facture;

    public function deleteFacture(int $factureId): void;

    /**
     * @return Facture[]
     */
    public function getFacturesByClient(int $clientId): array;
}
