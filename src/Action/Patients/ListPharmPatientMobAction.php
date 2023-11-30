<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Action\Patients;

use App\Domain\Patients\Service\PatientsList;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class ListPharmPatientMobAction
{
    private PatientsList $patientsList;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param PatientsList $smartboxList The user index list viewer
     * @param Responder $responder The responder
     */
    public function __construct(PatientsList $patientsList, Responder $responder)
    {
        $this->patientsList = $patientsList;
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
        // Optional: Pass parameters from the request to the findUsers method

        $sb = $this->patientsList->listPharmPatientMob($request->getAttribute('uid'));

        return $this->transform($response, $sb);
    }

    /**
     * Transform to json response.
     * This could also be done within a specific Responder class.
     *
     * @param ResponseInterface $response The response
     * @param array $users The users
     *
     * @return ResponseInterface The response
     */
    private function transform(ResponseInterface $response, array $sbs): ResponseInterface
    {

        return $this->responder->withJson(
            $response,$sbs
        );
    }
}
