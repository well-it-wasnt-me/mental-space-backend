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
final class UserTrackAction
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
        $userId = $request->getAttribute('uid');
        $coord = $request->getParsedBody();
        // Invoke the domain (service class)
        $user = $this->userReader->trackUser($userId, $coord['coordinates'], $coord['addr']);

        if ( $user )
        {
            return $this->responder
                ->withJson($response, ['status' => 'success'])
                ->withStatus(StatusCodeInterface::STATUS_OK);
        }

        return $this->responder
            ->withJson($response, ['status' => 'error'])
            ->withStatus(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
    }

    /**
     * Transform result to response.
     *
     * @param ResponseInterface $response The response
     * @param UserDataDoc $user The user
     *
     * @return ResponseInterface The response
     */
    private function transform(ResponseInterface $response, UserDataDoc $user): ResponseInterface
    {
        // Turn that object into a structured array
        $data = [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'user_type' => $user->user_type,
            'locale' => $user->locale,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ];

        // Turn all of that into a JSON string and put it into the response body
        return $this->responder->withJson($response, $data);
    }
}