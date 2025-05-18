<?php

namespace App\Service;

use App\Entity\Client;
use App\Entity\User;
use App\Dto\ClientDto;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

class ClientService implements ClientServiceInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private ClientRepository $clientRepository,
    ) {}

    /**
     * Crée un client rattaché à un utilisateur donné
     */
    public function createClient(User $user, ClientDto $dto): Client
    {
        $client = new Client();
        $client->setUser($user);
        $client->setNomGerant($dto->nomGerant);
        $client->setRaisonSociale($dto->raisonSociale);
        $client->setTelephone($dto->telephone);
        $client->setAdresse($dto->adresse);
        $client->setVille($dto->ville);
        $client->setPays($dto->pays);

        $this->em->persist($client);
        $this->em->flush();

        return $client;
    }
    /**
     * Met à jour un client existant
     */
    public function updateClient(int $clientId, ClientDto $dto): Client
    {
        $client = $this->clientRepository->find($clientId);

        if (!$client) {
            throw new EntityNotFoundException('Client non trouvé');
        }

        $client->setNomGerant($dto->nomGerant);
        $client->setRaisonSociale($dto->raisonSociale);
        $client->setTelephone($dto->telephone);
        $client->setAdresse($dto->adresse);
        $client->setVille($dto->ville);
        $client->setPays($dto->pays);

        $this->em->flush();

        return $client;
    }

    /**
     * Supprime un client et ses factures (cascade)
     */
    public function deleteClient(int $clientId): void
    {
        $client = $this->clientRepository->find($clientId);

        if (!$client) {
            throw new EntityNotFoundException('Client non trouvé');
        }

        $this->em->remove($client);
        $this->em->flush();
    }

    /**
     * Récupère tous les clients d’un utilisateur
     */
    public function getClientsByUser(User $user): array
    {
        return $this->clientRepository->findBy(['user' => $user]);
    }
}
