<?php

namespace App\Action\Reports;

use App\Domain\Tests\Repository\TestsRepository;
use App\Domain\Users\Repository\UserRepository;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EmotionsTestAction
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
    ): ResponseInterface
    {

        $uid = $request->getAttribute('uid');
        $data = $request->getParsedBody();
        $result = [];

        if ($this->testsRepository->addEmotionTest($uid, $data)) {
            $result = ['status' => 'success', 'message' => 'Sent'];
        } else {
            $result = ['status' => 'error', 'message' => 'Something went wrong'];
        }

        return $this->responder
            ->withJson($response, $result)
            ->withStatus(StatusCodeInterface::STATUS_OK);
    }
}
