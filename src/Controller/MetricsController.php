<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;
use Prometheus\Storage\InMemory;

class MetricsController
{
    #[Route('/metrics', name: 'metrics')]
    public function metrics(): Response
    {
        // Utilisation d'un stockage en mémoire (pas persistant entre requêtes)
        $registry = CollectorRegistry::getDefault();

        // Exemple : compteur de requêtes
        $counter = $registry->getOrRegisterCounter(
            'app',                // namespace
            'http_requests_total', // nom de la métrique
            'Nombre total de requêtes HTTP',
            ['route']
        );

        $counter->inc(['metrics']); // Incrémentation avec label "metrics"

        // Format de sortie Prometheus
        $renderer = new RenderTextFormat();
        $result = $renderer->render($registry->getMetricFamilySamples());

        return new Response($result, 200, ['Content-Type' => RenderTextFormat::MIME_TYPE]);
    }
}
