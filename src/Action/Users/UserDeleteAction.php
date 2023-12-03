<?php

namespace App\Action\Users;

use App\Domain\Users\Service\UserDeleter;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class UserDeleteAction
{
    private UserDeleter $userDeleter;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param UserDeleter $userDeleter The service
     * @param Responder $responder The responder
     */
    public function __construct(UserDeleter $userDeleter, Responder $responder)
    {
        $this->userDeleter = $userDeleter;
        $this->responder = $responder;
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
        $userId =  $request->getAttribute('uid');

        // Invoke the domain (service class)
        $this->userDeleter->deleteUser($userId);

        // Render the json response
        return $this->responder->withJson($response, [])->withStatus(StatusCodeInterface::STATUS_OK);
    }
}
