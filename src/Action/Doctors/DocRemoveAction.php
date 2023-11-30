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

final class DocRemoveAction
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

        $unset = $this->doctorRepository->unsetPaz($userId);

        return $this->responder
            ->withJson($response, ['status' => 'success'])
            ->withStatus(StatusCodeInterface::STATUS_OK);
    }
}
