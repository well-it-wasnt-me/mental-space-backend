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
final class AddPharmAction
{
    private PharmList $dsmList;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param PharmList $pharmList The user index list viewer
     * @param Responder $responder The responder
     */
    public function __construct(PharmList $pharmList, Responder $responder)
    {
        $this->dsmList = $pharmList;
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
        $q = $this->dsmList->addDrugPaz($data, $request->getAttribute('uid'));
        if (!$q) {
            $status = "error";
        } else {
            $status = "success";
        }
        return $this->responder->withJson($response, ['status' => $status]);
    }
}
