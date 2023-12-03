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
final class AddObiettivoAction
{
    private ObiettiviRepository $obiettiviRepository;
    private Responder $responder;

    /**
     * @param ObiettiviRepository $obiettiviRepository
     * @param Responder $responder
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
        $data = $request->getParsedBody();
        $q = $this->obiettiviRepository->addObjective($data, $request->getAttribute('uid'));

        if (!$q) {
            $status = "error";
        } else {
            $status = "success";
        }
        return $this->responder->withJson($response, ['status' => $status]);
    }
}
