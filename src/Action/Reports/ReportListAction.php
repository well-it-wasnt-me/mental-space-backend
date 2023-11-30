<?php

namespace App\Action\Reports;

use App\Domain\Reports\Service\ReportReader;
use App\Moebius\Definition;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ReportListAction
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

        if ($_SESSION['role'] != Definition::REPORTER) {
            if (isset($args['status'])) {
                $reports = $this->reportReader->listReportData($args['status']);
            } else {
                $reports = $this->reportReader->listReportData(null);
            }
        } else {
            // Fetch parameters from the request
            if (isset($args['status'])) {
                $reports = $this->reportReader->listReportDataUser($args['status']);
            } else {
                $reports = $this->reportReader->listReportDataUser(null);
            }
        }

        // Invoke the domain (service class)


        // Transform result
        return $this->responder->withJson($response, $reports);
    }
}
