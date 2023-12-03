<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Action\Obiettivi;

use App\Domain\Obiettivi\Repository\ObiettiviRepository;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class UpdateObiettivoAction
{
    private ObiettiviRepository $obiettiviRepository;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param CitiesList $citiesList The user index list viewer
     * @param Responder $responder The responder
     */
    public function __construct(ObiettiviRepository $obiettiviRepository, Responder $responder)
    {
        $this->obiettiviRepository = $obiettiviRepository;
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
        $uid = $request->getAttribute('uid');
        $data = $request->getParsedBody();
        // Optional: Pass parameters from the request to the findUsers method
        $gh = $this->obiettiviRepository->updateObjective($data['ob_id'], $data['obiettivo'], $uid);

        return $this->responder->withJson($response, $gh);
    }
}
