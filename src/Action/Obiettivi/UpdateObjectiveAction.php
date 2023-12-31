<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Action\Obiettivi;

use App\Domain\Obiettivi\Repository\ObjectiveRepository;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class UpdateObjectiveAction
{
    private ObjectiveRepository $obiettiviRepository;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param CitiesList $citiesList The cities list viewer
     * @param Responder $responder The responder
     */
    public function __construct(ObjectiveRepository $objectiveRepository, Responder $responder)
    {
        $this->obiettiviRepository = $objectiveRepository;
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
        $gh = $this->obiettiviRepository->updateObjective($data['ob_id'], $data['objective'], $uid);

        return $this->responder->withJson($response, $gh);
    }
}
