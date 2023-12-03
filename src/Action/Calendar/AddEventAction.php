<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Action\Calendar;

use App\Domain\Calendar\Repository\CalendarRepository;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class AddEventAction
{
    private CalendarRepository $calRepo;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param CalendarRepository $calRepo The user index list viewer
     * @param Responder $responder The responder
     */
    public function __construct(CalendarRepository $calRepo, Responder $responder)
    {
        $this->calRepo = $calRepo;
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
        $gh = $this->calRepo->addEvent($request->getParsedBody());

        if ($gh) {
            $gh = ['status' => 'success'];
        } else {
            $gh = ['status' => 'error'];
        }

        return $this->responder->withJson($response, $gh);
    }
}
