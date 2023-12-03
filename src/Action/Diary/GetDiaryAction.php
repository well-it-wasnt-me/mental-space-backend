<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Action\Diary;

use App\Domain\Diary\Repository\DiaryRepository;
use App\Domain\Doctors\Service\DocUpdate;
use App\Domain\Patients\Repository\PatientsRepository;
use App\Domain\Users\Repository\UserRepository;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use PHPMailer\PHPMailer\PHPMailer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetDiaryAction
{

    private DiaryRepository $repository;
    private Responder $responder;

    function __construct(DiaryRepository $repository, Responder $responder)
    {
        $this->repository = $repository;
        $this->responder = $responder;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface      $response
    ): ResponseInterface {

        $userId =  $request->getAttribute('uid');

        if (empty($userId)) {
            return $this->responder
                ->withJson($response, ['status' => 'error', 'message' => __('User Not Found, who are you ?')])
                ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        $entries = $this->repository->getEntries($userId);

        return $this->responder
            ->withJson($response, ['status' => 'success', 'entries' => $entries])
            ->withStatus(StatusCodeInterface::STATUS_OK);
    }
}
