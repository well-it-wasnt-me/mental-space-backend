<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Action\Patients;

use App\Domain\Patients\Service\PatientsAdd;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DelPatientAction
{

    private PatientsAdd $creator;
    private Responder $responder;

    function __construct(PatientsAdd $smartboxAdd, Responder $responder)
    {
        $this->creator = $smartboxAdd;
        $this->responder = $responder;
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

        $status = $this->creator->delPatient($args['paz_id']);

        if ($status['status'] == 'error') {
            return $this->responder
                ->withJson($response, ['status' => 'error', 'message' => $status['message']])
                ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        return $this->responder
            ->withJson($response, ['status' => 'success'])
            ->withStatus(StatusCodeInterface::STATUS_OK);
    }
}
