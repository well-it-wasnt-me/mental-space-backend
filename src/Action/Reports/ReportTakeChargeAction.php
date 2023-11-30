<?php

namespace App\Action\Reports;

use App\Domain\Reports\Repository\ReportRepository;
use App\Domain\Reports\Service\ReportReader;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class VLTDetailAction
 * @package App\Action\VLT
 */
final class ReportTakeChargeAction
{

    private ReportRepository $reportRepository;
    private $responder;

    /**
     * The constructor.
     *
     * @param ReportReader $reportReader The service
     * @param Responder $responder The responder
     */
    public function __construct(ReportRepository $reportRepository,Responder $responder)
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
        $reportID = (int)$args['report_id'];

        $row = ['user_id' => $_SESSION['user'], 'report_id' => $reportID];
        return $this->responder->withJson($response, $this->reportRepository->takeCharge($row));
    }
}
