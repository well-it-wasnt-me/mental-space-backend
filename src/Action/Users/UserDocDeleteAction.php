<?php

namespace App\Action\Users;

use App\Domain\Users\Service\UserDeleter;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class UserDocDeleteAction
{
    private UserDeleter $userDeleter;

    private Responder $responder;

    private SessionInterface $session;

    /**
     * The constructor.
     *
     * @param UserDeleter $userDeleter The service
     * @param Responder $responder The responder
     */
    public function __construct(UserDeleter $userDeleter, Responder $responder, SessionInterface $session)
    {
        $this->userDeleter = $userDeleter;
        $this->responder = $responder;
        $this->session = $session;
    }

    /**
     * Action.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     * @param array<mixed> $args The routing arguments
     *
     * @return ResponseInterface The response
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $userId =  $_SESSION['user_id'];

        // Invoke the domain (service class)
        $this->userDeleter->delDocUser($userId);
        $this->session->destroy();

        // Render the json response
        return $this->responder->withJson($response,[])->withStatus(StatusCodeInterface::STATUS_OK);
    }
}