<?php

namespace App\Action\Reports;

use App\Domain\Tests\Repository\TestsRepository;
use App\Domain\Users\Repository\UserRepository;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ListEmozioniTestAction
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
        ResponseInterface      $response
    ): ResponseInterface {

        $uid = $request->getAttribute('uid');

        $result = $this->testsRepository->listEmozioniTest($uid);

        return $this->responder
            ->withJson($response, $result)
            ->withStatus(StatusCodeInterface::STATUS_OK);




    }
}
