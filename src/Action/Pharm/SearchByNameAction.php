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
final class SearchByNameAction
{
    private PharmList $pharmList;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param CitiesList $citiesList The user index list viewer
     * @param Responder $responder The responder
     */
    public function __construct(PharmList $pharmList, Responder $responder)
    {
        $this->pharmList = $pharmList;
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
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $denom = $args['drug_name'];
        // Optional: Pass parameters from the request to the findUsers method
        $gh = $this->pharmList->searchPharm($denom);

        return $this->responder->withJson($response, $gh);
    }
}
