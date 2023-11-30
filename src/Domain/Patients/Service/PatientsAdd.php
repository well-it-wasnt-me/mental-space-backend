<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Domain\Patients\Service;

use App\Domain\Patients\Data\PatientData;
use App\Domain\Patients\Repository\PatientsRepository;

final class PatientsAdd
{
    private PatientsRepository $repository;

    /**
     * @param PatientsRepository $repository
     */
    public function __construct(PatientsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $data
     * @return array
     */
    public function addPatient(array $data): array
    {
        $sb = new PatientData($data);
        return $this->repository->insertPatient($sb, $data);
    }

    public function addPill($pill_id, $paz_id){
        return $this->repository->addPill($pill_id, $paz_id);
    }
    public function delPill($paz_id, $ass_id){
        return $this->repository->delPill($paz_id, $ass_id);
    }

    public function delPatient($paz_id){
        return $this->repository->deletePatient($paz_id);
    }

}


