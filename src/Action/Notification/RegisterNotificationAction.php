<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Action\Notification;

use App\Domain\Notification\Repository\NotificationRepository;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RegisterNotificationAction
{

    private Responder $responder;
    private NotificationRepository $repository;

    function __construct(Responder $responder, NotificationRepository $repository)
    {
        $this->responder = $responder;
        $this->repository = $repository;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface      $response
    ): ResponseInterface {

        $data = (array)$request->getParsedBody();

        if (empty($data)) {
            return $this->responder
                ->withJson($response, ['status' => 'error', 'message' => __('No Data Passed')])
                ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        $token = $data['registration_token'];

        $user_id = $request->getAttribute('uid');

        $esito = $this->repository->registerDevice($user_id, $token);
        if ($esito) {
            $ret = ['status' => 'success'];
        } else {
            $ret = ['status' => 'error'];
        }
        return $this->responder
            ->withJson($response, $ret)
            ->withStatus(StatusCodeInterface::STATUS_OK);
    }
}
