<?php

namespace App\Components;

use App\Entity\Beer;
use App\Service\BeerService;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class Dashboard
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    /** @var Beer[] $beers */
    public array $beers = [];

    public function __construct(
        private readonly BeerService $beerService
    ) {
        $this->beers = $this->beerService->findAll();
    }

    #[LiveAction]
    public function refresh(): void
    {
        $this->beers = $this->beerService->findAll();
    }
}