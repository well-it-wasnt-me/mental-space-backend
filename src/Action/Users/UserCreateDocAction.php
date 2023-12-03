<?php

namespace App\Action\Users;

use App\Domain\Users\Service\UserCreator;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class UserCreateDocAction
{
    private Responder $responder;

    private UserCreator $userCreator;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     * @param UserCreator $userCreator The service
     */
    public function __construct(Responder $responder, UserCreator $userCreator)
    {
        $this->responder = $responder;
        $this->userCreator = $userCreator;
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
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $userId = $this->userCreator->createDocUser($data);

        // Build the HTTP response
        return $this->responder
            ->withJson($response, ['status' => 'success','user_id' => $userId, 'message' => 'Account creato con successo, vai al login !'])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
