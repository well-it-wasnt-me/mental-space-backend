<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Action\Messages;

use App\Domain\Messages\Repository\MessagesRepository;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class ListContactsAction
{
    private MessagesRepository $msgRepo;
    private Responder $responder;

    /**
     * The constructor.
     *
     * @param MessagesRepository $msgRepo The user index list viewer
     * @param Responder $responder The responder
     */
    public function __construct(Responder $responder, MessagesRepository $msgRepo)
    {
        $this->msgRepo = $msgRepo;
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
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {

        $lista = $this->msgRepo->listContacts();
        return $this->transform($response, $lista);
    }

    /**
     * Transform to json response.
     * This could also be done within a specific Responder class.
     *
     * @param ResponseInterface $response The response
     * @param array $sbs Dont remember
     *
     * @return ResponseInterface The response
     */
    private function transform(ResponseInterface $response, array $sbs): ResponseInterface
    {

        return $this->responder->withJson(
            $response,
            ['contacts' => $sbs]
        );
    }
}
