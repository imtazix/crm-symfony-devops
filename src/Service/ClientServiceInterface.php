<?php

namespace App\Service;
use App\Dto\ClientDto;
use App\Entity\Client;
use App\Entity\User;

interface ClientServiceInterface
{
    public function createClient(User $user, ClientDto $dto): Client;

    public function updateClient(int $clientId, ClientDto $dto): Client;

    public function deleteClient(int $clientId): void;

    /**
     * @return Client[]
     */
    public function getClientsByUser(User $user): array;
}
