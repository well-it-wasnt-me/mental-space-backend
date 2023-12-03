<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Domain\Patients\Service;

use App\Domain\Patients\Data\SmartboxData;
use App\Domain\Patients\Repository\PatientsRepository;

final class PatientsList
{
    private PatientsRepository $repository;

    public function __construct(PatientsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listPaz(): array
    {
        return $this->repository->listPatients();
    }
    public function listPharmPatient($paz_id)
    {
        return $this->repository->listPharmPat($paz_id);
    }
    public function listPharmPatientMob($paz_id)
    {
        return $this->repository->listPharmPatMobile($paz_id);
    }
    public function last10moods($user_id)
    {
        return $this->repository->last10moods($user_id);
    }

    public function listDiaryEntries($user_id)
    {
        return $this->repository->listDiary($user_id);
    }

    public function listAllMood($user_id)
    {
        return $this->repository->listAllmoods($user_id);
    }

    public function searchPat($full_name)
    {
        return $this->repository->searchPat($full_name);
    }

    public function listAnnotation($paz_id)
    {
        return $this->repository->listAnnotation($paz_id);
    }

    public function addAnnotation(array $data)
    {
        return $this->repository->addAnnotation($data);
    }

    public function deleteAnnotation(int $ann_id)
    {
        return $this->repository->deleteAnnotation($ann_id);
    }

    public function loadRelazione(int $paz_id)
    {
        return $this->repository->caricaRelazione($paz_id);
    }

    public function salvaRelazione($paz_id, $content)
    {
        return $this->repository->salvaRelazione($paz_id, $content);
    }

    public function selectSearchPat($name)
    {
        return $this->repository->selectSearchPat($name);
    }

    public function listAllDepre($paz_id)
    {
        return $this->repository->listDepressione($paz_id);
    }

    public function searchPatientSelect($term)
    {
        return $this->repository->searchPatient($term);
    }
}
