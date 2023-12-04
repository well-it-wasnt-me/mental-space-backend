<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Action\Diary;

use App\Domain\Diary\Repository\DiaryRepository;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UploadDiaryAction
{

    private Responder $responder;
    private DiaryRepository $repository;

    function __construct(Responder $responder, DiaryRepository $repository)
    {
        $this->responder = $responder;
        $this->repository = $repository;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface      $response
    ): ResponseInterface {

        $user_id = $request->getAttribute('uid');

        if (empty($user_id)) {
            return $this->responder
                ->withJson($response, ['status' => 'error', 'message' => __('No Data Passed')])
                ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        $data = (array)$request->getParsedBody();
        if (empty($data)) {
            $data = json_decode(file_get_contents('php://input'), true);
        }

        $entry = $this->repository->addEntry($user_id, $data);
        if ($entry) {
            return $this->responder
                ->withJson($response, ['status' => 'success', 'message' => __('Success')])
                ->withStatus(StatusCodeInterface::STATUS_OK);
        }


        return $this->responder
            ->withJson($response, ['status' => 'error', 'message' => __('Error')])
            ->withStatus(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
    }
}
