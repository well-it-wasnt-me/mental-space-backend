<?php

namespace App\Action\Users;

use App\Domain\Users\Data\UserDataDoc;
use App\Domain\Users\Service\UserReader;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class UserHistoryAction
{
    private UserReader $userReader;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param UserReader $userViewer The service
     * @param Responder $responder The responder
     */
    public function __construct(UserReader $userViewer, Responder $responder)
    {
        $this->userReader = $userViewer;
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
        ResponseInterface $response
    ): ResponseInterface {
        // Fetch parameters from the request
        $userId = $_SESSION['user_id'];
        // Invoke the domain (service class)
        $user = $this->userReader->listHistoryAccess($userId);

        return $this->responder
                ->withJson($response, ['status' => 'success', 'history' => $user])
                ->withStatus(StatusCodeInterface::STATUS_OK);

    }
}