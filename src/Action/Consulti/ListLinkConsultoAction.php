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

final class ListLinkConsultoAction
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
        ResponseInterface      $response,
        array $args
    ): ResponseInterface {

        if (empty($args)) {
            return $this->responder
                ->withJson($response, ['status' => 'error', 'message' => __('No Data Passed')])
                ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        $result = $this->consultiRepository->listaConsulti($args['paz_id']);

        return $this->responder
                ->withJson($response, $result)
                ->withStatus(StatusCodeInterface::STATUS_OK);
        }
}
