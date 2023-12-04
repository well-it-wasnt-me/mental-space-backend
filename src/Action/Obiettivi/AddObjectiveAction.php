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
final class AddObjectiveAction
{
    private ObjectiveRepository $objectiveRepository;
    private Responder $responder;

    /**
     * @param ObjectiveRepository $obiettiviRepository
     * @param Responder $responder
     */
    public function __construct(ObjectiveRepository $obiettiviRepository, Responder $responder)
    {
        $this->objectiveRepository = $obiettiviRepository;
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
        $data = $request->getParsedBody();
        $q = $this->objectiveRepository->addObjective($data, $request->getAttribute('uid'));

        if (!$q) {
            $status = "error";
        } else {
            $status = "success";
        }
        return $this->responder->withJson($response, ['status' => $status]);
    }
}
