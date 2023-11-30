<?php

namespace App\Action\Reports;

use App\Domain\Reports\Repository\ReportRepository;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class ReportDeleteAction
{
    private ReportRepository $reportRepository;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param ReportRepository $reportRepository The service
     * @param Responder $responder The responder
     */
    public function __construct(ReportRepository $reportRepository, Responder $responder)
    {
        $this->reportRepository = $reportRepository;
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

        // @todo
        // Invoke the domain (service class)
        $delete = $this->reportRepository->deleteReportById($reportID);

        // Render the json response
        return $this->responder->withJson($response, $delete);
    }
}
