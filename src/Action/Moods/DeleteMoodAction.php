<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Action\Moods;

use App\Domain\Moods\Repository\MoodsRepository;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DeleteMoodAction
{

    private Responder $responder;
    private MoodsRepository $repository;

    function __construct(Responder $responder, MoodsRepository $repository)
    {
        $this->responder = $responder;
        $this->repository = $repository;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface      $response,
        $args
    ): ResponseInterface {

        $user_id = $request->getAttribute('uid');
        $mood_id = $args['mood_id'];

        if (empty($user_id)) {
            return $this->responder
                ->withJson($response, ['status' => 'error', 'message' => __('No Data Passed')])
                ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
        }



        $mood = $this->repository->deleteMood($mood_id, $user_id);
        if ($mood) {
            $status = 'success';
        } else {
            $status = 'error';
        }
        return $this->responder
            ->withJson($response, ['status' => $status])
            ->withStatus(StatusCodeInterface::STATUS_OK);
    }
}
