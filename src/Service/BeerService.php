<?php

namespace App\Service;

use App\Entity\Beer;
use App\Repository\BeerRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BeerService
{
    public function __construct(
        private readonly BeerRepository $beerRepository,
        private readonly HttpClientInterface $dummyJsonClient
    ){
    }

    public function addRandomBeer(): void
    {
        $data = $this
            ->dummyJsonClient
            ->request('GET', 'https://random-data-api.com/api/v2/beers/')
            ->toArray();

        $beer = (new Beer())
            ->setBrand($data['brand'])
            ->setName($data['name']);

        $this->beerRepository->add($beer);
    }

    public function findAll(): array
    {
        return $this->beerRepository->findAll();
    }
}