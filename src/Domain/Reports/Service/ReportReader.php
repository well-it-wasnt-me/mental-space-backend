<?php


namespace App\Domain\Reports\Service;

use App\Domain\Reports\Data\ReportData;
use App\Domain\Reports\Repository\ReportRepository;

/**
 * Service.
 */
final class ReportReader
{
    private ReportRepository $repository;

    /**
     * The constructor.
     *
     * @param ReportRepository $repository The repository
     */
    public function __construct(ReportRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read
     *
     * @param int $reportID The user id
     *
     * @return VLTData The user data
     */
    public function getReportData(int $reportID): ReportData
    {
        // Input validation
        // ...

        // Fetch data from the database
        $report = $this->repository->getReportByID($reportID);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Optional: Map result
        // ...

        return $report;
    }
    public function listReportData($status): array
    {
        // Input validation
        // ...

        // Fetch data from the database
        return $this->repository->listReports($status);
    }

    public function listReportDataUser($status): array
    {
        // Input validation
        // ...

        // Fetch data from the database
        return $this->repository->listReportsUser($status);

    }
}