<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Action\Dsm;


use App\Domain\Dsm\Repository\DsmRepository;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class WebDsmSearchByNameAction
{
    private DsmRepository $dsmRepository;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param DsmRepository $dsmRepository The user index list viewer
     * @param Responder $responder The responder
     */
    public function __construct(DsmRepository $dsmRepository, Responder $responder)
    {
        $this->dsmRepository = $dsmRepository;
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
        $denom = $request->getParsedBody();
        $gh = $this->dsmRepository->selectListDsm($denom['term']);

        return $this->responder->withJson($response, $gh);
    }
}
