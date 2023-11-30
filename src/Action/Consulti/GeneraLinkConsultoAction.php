<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Action\Consulti;


use App\Domain\Consulti\Repository\ConsultiRepository;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GeneraLinkConsultoAction
{

    private Responder $responder;
    private ConsultiRepository $consultiRepository;

    function __construct(Responder $responder, ConsultiRepository $consultiRepository)
    {
        $this->responder = $responder;
        $this->consultiRepository = $consultiRepository;
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

        if( !filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
            return $this->responder
                ->withJson($response, ['status' => 'error', 'message' => __('Indirizzo E-Mail non corretto')])
                ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        $result = $this->consultiRepository->generaLink($data['email'], $data['paz_id']);

        return $this->responder
                ->withJson($response, $result)
                ->withStatus(StatusCodeInterface::STATUS_OK);
        }
}
