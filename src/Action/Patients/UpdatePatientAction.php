<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Action\Patients;

use App\Domain\Patients\Repository\PatientsRepository;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class UpdatePatientAction
{
    private PatientsRepository $repository;

    private Responder $responder;

    /**
     * @param PatientsRepository $repository
     * @param Responder $responder
     */
    public function __construct(PatientsRepository $repository, Responder $responder)
    {
        $this->repository = $repository;
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
        if ($this->repository->updatePatient($data, $data)) {
            return $this->responder
                ->withJson($response, ['status' => 'success'])
                ->withStatus(StatusCodeInterface::STATUS_OK);
        } else {
            return $this->responder
                ->withJson($response, ['status' => 'error'])
                ->withStatus(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }
    }
}
