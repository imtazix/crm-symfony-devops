<?php

namespace App\Service;

use App\Entity\Facture;
use App\Dto\FactureDto;
use App\Repository\ClientRepository;
use App\Repository\FactureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

class FactureService implements FactureServiceInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private FactureRepository $factureRepository,
        private ClientRepository $clientRepository,
    ) {}

    /**
     * Crée une facture pour un client donné
     */
    public function createFacture(int $clientId, FactureDto $dto): Facture
    {
        $client = $this->clientRepository->find($clientId);

        if (!$client) {
            throw new EntityNotFoundException('Client non trouvé');
        }

        $facture = new Facture();
        $facture->setClient($client);
        $facture->setNumero($dto->numero);
        $facture->setDate($dto->date); // ✅ plus besoin de conversion
        $facture->setMontant($dto->montant);
        $facture->setEtat($dto->etat);
        $facture->setNote($dto->note);

        $this->em->persist($facture);
        $this->em->flush();

        return $facture;
    }

    /**
     * Met à jour une facture existante
     */
    public function updateFacture(int $factureId, FactureDto $dto): Facture
    {
        $facture = $this->factureRepository->find($factureId);

        if (!$facture) {
            throw new EntityNotFoundException('Facture non trouvée');
        }

        $facture->setNumero($dto->numero);
        $facture->setDate($dto->date); // ✅ pas de new \DateTime(...)
        $facture->setMontant($dto->montant);
        $facture->setEtat($dto->etat);
        $facture->setNote($dto->note);

        $this->em->flush();

        return $facture;
    }

    public function deleteFacture(int $factureId): void
    {
        $facture = $this->factureRepository->find($factureId);

        if (!$facture) {
            throw new EntityNotFoundException('Facture non trouvée');
        }

        $this->em->remove($facture);
        $this->em->flush();
    }

    public function getFacturesByClient(int $clientId): array
    {
        return $this->factureRepository->findBy(['client' => $clientId]);
    }
}
