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

final class ListMoodGraphAction
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
        ResponseInterface      $response
    ): ResponseInterface {

        $user_id = $request->getAttribute('uid');

        if (empty($user_id)) {
            return $this->responder
                ->withJson($response, ['status' => 'error', 'message' => __('No Data Passed')])
                ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
        }



        $mood = $this->repository->ultimi10moodGraph($user_id);

        return $this->responder
            ->withJson($response, $mood)
            ->withStatus(StatusCodeInterface::STATUS_OK);
    }
}
