<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Domain\Pharm\Service;

use App\Domain\Pharm\Repository\PharmRepository;

final class PharmList
{
    private PharmRepository $repository;

    public function __construct(PharmRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listPharm($for_select = false): array
    {
        return $this->repository->listDrugs($for_select);
    }

    public function searchPharm($denom): array
    {
        return $this->repository->seaerchDrug($denom);
    }

    public function deletePazDrug($id, $uid)
    {
        return $this->repository->deleteDrug($id, $uid);
    }
    public function addDrugPaz($data, $uid)
    {
        return $this->repository->addDrug($data, $uid);
    }

    public function webListPharm($term)
    {
        return $this->repository->webSearchDrug($term);
    }
}
