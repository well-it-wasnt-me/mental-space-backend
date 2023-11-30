<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Action\Doctors;

use App\Domain\Doctors\Service\DocUpdate;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UpdateDoctorAction
{

    private DocUpdate $creator;
    private Responder $responder;

    function __construct(DocUpdate $docUpdate, Responder $responder)
    {
        $this->creator = $docUpdate;
        $this->responder = $responder;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface      $response
    ): ResponseInterface {

        $data = (array)$request->getParsedBody();

        if (empty($data)) {
            return $this->responder
                ->withJson($response, ['status' => 'error', 'message' => __('No Data Passed')])
                ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        $status = $this->creator->updateDoctor($data);

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
