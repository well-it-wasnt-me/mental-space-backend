<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Domain\Cities\Service;

use App\Domain\Cities\Repository\CitiesRepository;

final class CitesList
{
    private CitiesRepository $repository;

    public function __construct(CitiesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listCities(): array
    {
        return $this->repository->listCities();
    }
}
