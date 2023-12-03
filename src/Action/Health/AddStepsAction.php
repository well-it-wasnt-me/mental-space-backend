<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Action\Health;

use App\Domain\Health\Repository\HealthRepository;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class AddStepsAction
{
    private HealthRepository $health;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param CitiesList $citiesList The user index list viewer
     * @param Responder $responder The responder
     */
    public function __construct(HealthRepository $health, Responder $responder)
    {
        $this->health = $health;
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
        $gh = $this->health->aggiungiPassi($request->getAttribute('uid'), $data['steps']);

        if ($gh) {
            $result = ['status' => 'success'];
        } else {
            $result = ['status' => 'error'];
        }

        return $this->responder->withJson($response, $result);
    }
}
