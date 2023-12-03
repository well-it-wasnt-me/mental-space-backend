<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Domain\Dsm\Service;

use App\Domain\Dsm\Repository\DsmRepository;

final class DsmList
{
    private DsmRepository $repository;

    public function __construct(DsmRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listDsm(): array
    {
        return $this->repository->listDsm();
    }
}
