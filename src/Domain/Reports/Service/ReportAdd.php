<?php


namespace App\Domain\Reports\Service;

use App\Domain\Reports\Data\ReportData;
use App\Domain\Reports\Repository\ReportRepository;

/**
 * Service.
 */
final class ReportAdd
{
    private ReportRepository $repository;

    private ReportValidator $reportValidator;

    /**
     * The constructor.
     *
     * @param ReportRepository $repository The repository
     */
    public function __construct(
        ReportRepository $repository,
        ReportValidator  $reportValidator
    )
    {
        $this->repository = $repository;
        $this->reportValidator = $reportValidator;
    }

    /**
     * Add
     *
     * @param array $data The user id
     *
     * @return int The user data
     */
    public function addReport(array $data): int
    {
        // Input validation
        $this->reportValidator->validateReport($data);

        $report = new ReportData($data);

        // Insert data
        return $this->repository->insertReport($report);

    }
}