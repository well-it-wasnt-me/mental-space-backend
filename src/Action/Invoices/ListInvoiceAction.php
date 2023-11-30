<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Action\Invoices;

use App\Domain\Invoices\Repository\InvoicesRepository;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class ListInvoiceAction
{
    private InvoicesRepository $invRepo;
    private Responder $responder;

    /**
     * The constructor.
     *
     * @param InvoicesRepository $invRepo The user index list viewer
     * @param Responder $responder The responder
     */
    public function __construct( Responder $responder, InvoicesRepository $invRepo )
    {
        $this->invRepo = $invRepo;
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

        $invoices = $this->invRepo->listInvoices();
        return $this->transform($response, $invoices);
    }

    /**
     * Transform to json response.
     * This could also be done within a specific Responder class.
     *
     * @param ResponseInterface $response The response
     * @param array $users The users
     *
     * @return ResponseInterface The response
     */
    private function transform(ResponseInterface $response, array $sbs): ResponseInterface
    {

        return $this->responder->withJson(
            $response,
            ['data' => $sbs]
        );
    }
}
