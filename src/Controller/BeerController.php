<?php

namespace App\Controller;

use App\Service\BeerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BeerController extends AbstractController
{
    public function __construct(
        private readonly BeerService $beerService
    ) {
    }

    #[Route('/add-beer', name: 'app_event', methods: ['POST'], condition: "request.headers.get('X-AUTH') == 'CRON-JOB'")]
    public function addBeer(): Response
    {
        $this->beerService->addRandomBeer();

        return $this->json([
            'success' => true
        ]);
    }
}
