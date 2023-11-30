<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Action\Doctors;

use App\Domain\Doctors\Repository\DoctorRepository;
use App\Domain\Doctors\Service\DocUpdate;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DocDetailAppAction
{

    private DoctorRepository $doctorRepository;
    private Responder $responder;

    function __construct(DoctorRepository $doctorRepository, Responder $responder)
    {
        $this->doctorRepository = $doctorRepository;
        $this->responder = $responder;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface      $response
    ): ResponseInterface {

        $userId =  $request->getAttribute('uid');

        if (empty($userId)) {
            return $this->responder
                ->withJson($response, ['status' => 'error', 'message' => __('No Data Passed')])
                ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        $docData = $this->doctorRepository->AppdoctorDetail($userId);

        if (empty($docData)) {
            return $this->responder
                ->withJson($response, [])
                ->withStatus(StatusCodeInterface::STATUS_OK);
        }

        return $this->responder
            ->withJson($response, $docData)
            ->withStatus(StatusCodeInterface::STATUS_OK);
    }
}
