<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Action\Consult;

use App\Domain\Consult\Repository\ConsultRepository;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GenerateConsultLinkAction
{

    private Responder $responder;
    private ConsultRepository $ConsultRepository;

    function __construct(Responder $responder, ConsultRepository $ConsultRepository)
    {
        $this->responder = $responder;
        $this->ConsultRepository = $ConsultRepository;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface      $response
    ): ResponseInterface {

        $data = $request->getParsedBody();

        if (empty($data)) {
            return $this->responder
                ->withJson($response, ['status' => 'error', 'message' => __('No Data Passed')])
                ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return $this->responder
                ->withJson($response, ['status' => 'error', 'message' => __('E-Mail Address is not correct')])
                ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        $result = $this->ConsultRepository->generaLink($data['email'], $data['paz_id']);

        return $this->responder
                ->withJson($response, $result)
                ->withStatus(StatusCodeInterface::STATUS_OK);
    }
}
