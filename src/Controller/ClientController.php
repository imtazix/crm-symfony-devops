<?php

namespace App\Controller;

use App\Dto\ClientDto;
use App\Form\ClientType;
use App\Service\ClientServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Attribute\IsGranted;



#[IsGranted('ROLE_USER')]
class ClientController extends AbstractController
{
    public function __construct(private ClientServiceInterface $clientService) {}

    #[Route('/clients', name: 'client_list')]
    public function list(): Response
    {
        $user = $this->getUser();
        $clients = $this->clientService->getClientsByUser($user);

        return $this->render('client/list.html.twig', ['clients' => $clients]);
    }

    #[Route('/clients/create', name: 'client_create')]
    public function create(Request $request): Response
    {
        $clientDto = new ClientDto();
        $form = $this->createForm(ClientType::class, $clientDto);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();

            $this->clientService->createClient($user, $clientDto);

            $this->addFlash('success', 'Client créé avec succès !');

            return $this->redirectToRoute('client_list');
        }

        return $this->render('client/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/clients/{id}/edit', name: 'client_edit')]
    public function edit(Request $request, int $id): Response
    {
        $client = $this->clientService->getClientsByUser($this->getUser());
        $client = array_filter($client, fn($c) => $c->getId() === $id);
        $client = reset($client);

        if (!$client) {
            throw $this->createNotFoundException('Client non trouvé');
        }

        $clientDto = new ClientDto();
        // Remplir DTO avec les données existantes
        $clientDto->nomGerant = $client->getNomGerant();
        $clientDto->raisonSociale = $client->getRaisonSociale();
        $clientDto->telephone = $client->getTelephone();
        $clientDto->adresse = $client->getAdresse();
        $clientDto->ville = $client->getVille();
        $clientDto->pays = $client->getPays();

        $form = $this->createForm(ClientType::class, $clientDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->clientService->updateClient($id, $clientDto);
            $this->addFlash('success', 'Client modifié avec succès !');

            return $this->redirectToRoute('client_list');
        }

        return $this->render('client/edit.html.twig', [
            'form' => $form->createView(),
            'clientId' => $id,
        ]);
    }

    #[Route('/clients/{id}/delete', name: 'client_delete', methods: ['POST'])]
    public function delete(Request $request, int $id): Response
    {
        if (!$this->isCsrfTokenValid('delete_client_'.$id, $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Token CSRF invalide.');
        }

        $this->clientService->deleteClient($id);
        $this->addFlash('success', 'Client supprimé avec succès !');

        return $this->redirectToRoute('client_list');
    }
}
