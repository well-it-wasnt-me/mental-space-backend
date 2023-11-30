<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Action\Cities;


use App\Domain\Cities\Service\CitesList;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class ListCitiesAction
{
    private CitesList $citiesList;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param CitiesList $citiesList The user index list viewer
     * @param Responder $responder The responder
     */
    public function __construct(CitesList $citiesList, Responder $responder)
    {
        $this->citiesList = $citiesList;
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
        $gh = $this->citiesList->listCities();

        return $this->responder->withJson($response, $gh);
    }
}
