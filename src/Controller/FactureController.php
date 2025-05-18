<?php

namespace App\Controller;

use App\Dto\FactureDto;
use App\Form\FactureType;
use App\Service\FactureServiceInterface;
use App\Repository\FactureRepository;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class FactureController extends AbstractController
{
    public function __construct(
        private FactureServiceInterface $factureService,
        private ClientRepository $clientRepository,
        private FactureRepository $factureRepository,
    ) {}

    #[Route('/clients/{clientId}/factures', name: 'facture_list')]
    public function list(int $clientId): Response
    {
        $client = $this->clientRepository->find($clientId);
        if (!$client) {
            throw $this->createNotFoundException('Client non trouvé');
        }

        $factures = $this->factureService->getFacturesByClient($clientId);

        return $this->render('facture/list.html.twig', [
            'client' => $client,
            'factures' => $factures,
        ]);
    }

    #[Route('/clients/{clientId}/factures/create', name: 'facture_create')]
    public function create(Request $request, int $clientId): Response
    {
        $client = $this->clientRepository->find($clientId);
        if (!$client) {
            throw $this->createNotFoundException('Client non trouvé');
        }

        $factureDto = new FactureDto();
        $form = $this->createForm(FactureType::class, $factureDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->factureService->createFacture($clientId, $factureDto);
            $this->addFlash('success', 'Facture créée avec succès !');

            return $this->redirectToRoute('facture_list', ['clientId' => $clientId]);
        }

        return $this->render('facture/create.html.twig', [
            'form' => $form->createView(),
            'client' => $client,
        ]);
    }

    #[Route('/factures/{id}/edit', name: 'facture_edit')]
    public function edit(Request $request, int $id): Response
    {
        $facture = $this->factureRepository->find($id);
        if (!$facture) {
            throw $this->createNotFoundException('Facture non trouvée');
        }

        $factureDto = new FactureDto();
        $factureDto->numero = $facture->getNumero();
        $factureDto->date = $facture->getDate(); // ✅ on garde l’objet DateTime
        $factureDto->montant = $facture->getMontant();
        $factureDto->etat = $facture->getEtat();
        $factureDto->note = $facture->getNote();

        $form = $this->createForm(FactureType::class, $factureDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->factureService->updateFacture($id, $factureDto);
            $this->addFlash('success', 'Facture modifiée avec succès !');

            return $this->redirectToRoute('facture_list', [
                'clientId' => $facture->getClient()->getId()
            ]);
        }

        return $this->render('facture/edit.html.twig', [
            'form' => $form->createView(),
            'facture' => $facture,
        ]);
    }

    #[Route('/factures/{id}/delete', name: 'facture_delete', methods: ['POST'])]
    public function delete(Request $request, int $id): Response
    {
        if (!$this->isCsrfTokenValid('delete_facture_' . $id, $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Token CSRF invalide.');
        }

        $facture = $this->factureRepository->find($id);
        if (!$facture) {
            throw $this->createNotFoundException('Facture non trouvée');
        }

        $clientId = $facture->getClient()->getId();
        $this->factureService->deleteFacture($id);

        $this->addFlash('success', 'Facture supprimée avec succès !');

        return $this->redirectToRoute('facture_list', ['clientId' => $clientId]);
    }
}
