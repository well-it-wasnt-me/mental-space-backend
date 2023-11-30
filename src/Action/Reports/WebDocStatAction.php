<?php

namespace App\Action\Reports;

use App\Domain\Reports\Repository\ReportRepository;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class WebDocStatAction
{
    private Responder $responder;
    private ReportRepository $repository;
    function __construct(Responder $responder, ReportRepository $repository)
    {
        $this->repository = $repository;
        $this->responder = $responder;
    }


    /**
     * Action.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     *
     * @return ResponseInterface The response
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface      $response
    ): ResponseInterface {

        $result = $this->repository->getDocStat($_SESSION['user_id']);

        return $this->responder
            ->withJson($response, $result)
            ->withStatus(StatusCodeInterface::STATUS_OK);




    }
}
