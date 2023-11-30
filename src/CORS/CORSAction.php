<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\CORS;

use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CORSAction
{


    private Responder $responder;

    function __construct(Responder $responder)
    {
        $this->responder = $responder;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface      $response
    ): ResponseInterface {

            return $this->responder
                ->withJson($response, [])
                ->withStatus(StatusCodeInterface::STATUS_OK);
    }
}
