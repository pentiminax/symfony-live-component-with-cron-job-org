<?php

namespace App\Controller;

use App\Service\EventService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    public function __construct(
        private readonly EventService $eventService
    ) {
    }

    #[Route('/check-events', name: 'app_event', methods: ['POST'], condition: "request.headers.get('X-AUTH') == 'CRON-JOB'")]
    public function checkEvents(): Response
    {
        $this->eventService->checkFutureEvents();

        return $this->json([
            'success' => true
        ]);
    }
}
