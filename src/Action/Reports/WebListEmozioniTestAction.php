<?php

namespace App\Action\Reports;

use App\Domain\Tests\Repository\TestsRepository;
use App\Domain\Users\Repository\UserRepository;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class WebListEmozioniTestAction
{
    private Responder $responder;
    private TestsRepository $testsRepository;
    function __construct(Responder $responder, TestsRepository $testsRepository, UserRepository $userRepository)
    {
        $this->testsRepository = $testsRepository;
        $this->responder = $responder;
    }


    /**
     * Action.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     *
     * @return ResponseInterface The response
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface      $response,
        array $args
    ): ResponseInterface {

        if(empty($args)){
            return $this->responder
                ->withJson($response, [])
                ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        $result = $this->testsRepository->listEmozioniTest($args['user_id']);

        return $this->responder
            ->withJson($response, $result)
            ->withStatus(StatusCodeInterface::STATUS_OK);




    }
}
