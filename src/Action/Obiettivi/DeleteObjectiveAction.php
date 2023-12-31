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
final class DeleteObjectiveAction
{
    private ObjectiveRepository $obiettiviRepository;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param CitiesList $citiesList The user index list viewer
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
        $data = $request->getParsedBody();
        $q = $this->obiettiviRepository->deleteObjective($data['ob_id'], $request->getAttribute('uid'));

        if (!$q) {
            $status = "error";
        } else {
            $status = "success";
        }
        return $this->responder->withJson($response, ['status' => $status]);
    }
}
