<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Domain\Doctors\Service;

use App\Domain\Doctors\Data\DoctorData;
use App\Domain\Doctors\Repository\DoctorRepository;

final class DocUpdate
{
    private DoctorRepository $repository;

    /**
     * @param DoctorRepository $repository
     */
    public function __construct(DoctorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $data
     * @return array
     */
    public function updateDoctor(array $data): array
    {
        $data = new DoctorData($data);
        return $this->repository->updateDoctor($data);
    }

}


