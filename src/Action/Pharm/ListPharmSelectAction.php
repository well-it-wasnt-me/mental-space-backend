<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Action\Pharm;


use App\Domain\Pharm\Service\PharmList;
use App\Domain\Cities\Service\CitesList;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class ListPharmSelectAction
{
    private PharmList $dsmList;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param CitiesList $citiesList The user index list viewer
     * @param Responder $responder The responder
     */
    public function __construct(PharmList $dsmList, Responder $responder)
    {
        $this->dsmList = $dsmList;
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
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the findUsers method
        $gh = $this->dsmList->listPharm(true);

        return $this->responder->withJson($response, ['results' => $gh]);
    }
}
