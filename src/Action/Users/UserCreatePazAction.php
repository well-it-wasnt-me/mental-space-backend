<?php

namespace App\Action\Users;

use App\Domain\Users\Service\UserCreator;
use App\Moebius\Logger;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class UserCreatePazAction
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

        $logger = new Logger('create_user.log', true, true);

        // Extract the form data from the request body
        $data = json_decode(file_get_contents("php://input"), true);

        if (json_last_error() != JSON_ERROR_NONE) {
            $logger->info($data);
            $logger->error(file_get_contents("php://input"));
            $logger->critical(json_last_error_msg());
        }

        $userId = $this->userCreator->createPazUser($data);

        if( $userId == 0){
            return $this->responder
                ->withJson($response, ['status' => 'error', 'message' => 'Sono arrivati male i dati :('])
                ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        // Build the HTTP response
        return $this->responder
            ->withJson($response, ['status' => 'success','user_id' => $userId, 'message' => 'Account creato con successo, vai al login !'])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}