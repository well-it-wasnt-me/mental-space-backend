<?php

namespace App\Action\Reports;

use App\Domain\Reports\Data\ReportData;
use App\Domain\Reports\Service\ReportReader;
use App\Responder\Responder;
use PHP_CodeSniffer\Reports\Report;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class VLTDetailAction
 * @package App\Action\VLT
 */
final class ReportDetailAction
{

    private ReportReader $reportReader;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param ReportReader $reportReader The service
     * @param Responder $responder The responder
     */
    public function __construct(ReportReader $reportReader, Responder $responder)
    {
        $this->reportReader = $reportReader;
        $this->responder = $responder;
    }

    /**
     * Action.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     * @param array<mixed> $args The routing arguments
     *
     * @return ResponseInterface The response
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $reportID = (int)$args['id'];

        // Invoke the domain (service class)
        $report = $this->reportReader->getReportData($reportID);

        // Transform result
        return $this->transform($response, $report);
    }

    /**
     * Transform result to response.
     *
     * @param ResponseInterface $response The response
     * @param ReportData $report The report
     *
     * @return ResponseInterface The response
     */
    private function transform(ResponseInterface $response, ReportData $report): ResponseInterface
    {
        // Turn that object into a structured array
        $data = [
            'id'            => $report->id,
            'photo'         => $report->photo,
            'user_id'       => $report->user_id,
            'lon'           => $report->lon,
            'lat'           => $report->lat,
            'status'        => $report->status,
            'notes'         => $report->notes,
            'report_type'   => $report->report_type,
            'created_at'    => $report->created_at,
            'updated_at'    => $report->updated_at,
            'full_addr'     => $report->full_addr,
            'city'          => $report->city,
            'county'        => $report->county,
        ];

        // Turn all of that into a JSON string and put it into the response body
        return $this->responder->withJson($response, $data);
    }
}
