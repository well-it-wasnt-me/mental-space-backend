<?php

namespace App\Action\Users;

use App\Domain\Users\Service\UserUpdater;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class UserUpdateAddrAction
{
    private Responder $responder;

    private UserUpdater $userUpdater;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     * @param UserUpdater $userUpdater The service
     */
    public function __construct(Responder $responder, UserUpdater $userUpdater)
    {
        $this->responder = $responder;
        $this->userUpdater = $userUpdater;
    }

    /**
     * Action.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     * @param array $args The route arguments
     *
     * @return ResponseInterface The response
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $userId =  $request->getAttribute('uid');
        $data = json_decode(file_get_contents('php://input'), true);

        // Invoke the Domain with inputs and retain the result
        $data = $this->userUpdater->updateUserAddr($userId, $data);

        // Build the HTTP response
        return $this->responder->withJson($response, $data)->withStatus(200);
    }
}
