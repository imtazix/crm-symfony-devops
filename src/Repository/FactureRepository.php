<?php

namespace App\Repository;

use App\Entity\Facture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Facture>
 */
class FactureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Facture::class);
    }

    // 🔍 Exemple : trouver toutes les factures d’un client
    public function findByClientId(int $clientId): array
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.client = :clientId')
            ->setParameter('clientId', $clientId)
            ->getQuery()
            ->getResult();
    }
}
