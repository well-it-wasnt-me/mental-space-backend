<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Action\Consulti;

use App\Domain\Consulti\Repository\ConsultRepository;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PinCodeActionCheck
{

    private Responder $responder;
    private ConsultRepository $consultiRepository;

    function __construct(Responder $responder, ConsultRepository $consultiRepository)
    {
        $this->responder = $responder;
        $this->consultiRepository = $consultiRepository;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface      $response
    ): ResponseInterface {

        $pin = $request->getParsedBody();

        if (empty($pin)) {
            return $this->responder
                ->withJson($response, ['status' => 'error', 'message' => __('No Data Passed')])
                ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        $result = [];
        if ($this->consultiRepository->checkPinCode($pin['pin_code'])) {
            $result = ['status' => 'success'];
        } else {
            $result = ['status' => 'error'];
        }

        return $this->responder
                ->withJson($response, $result)
                ->withStatus(StatusCodeInterface::STATUS_OK);
    }
}
