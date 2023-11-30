<?php

namespace App\Action\Pages;

use App\Moebius\Definition;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;
use Stripe\StripeClient;

\Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

final class CreateCheckoutSession
{
    /**
     * @var PhpRenderer */
    private $renderer;

    public function __construct(PhpRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

        $YOUR_DOMAIN = getenv('DOMAIN');

        if (!isset($_SESSION['user_id'])) {
            header("HTTP/1.1 303 See Other");
            return $response->withHeader('Content-Type', 'application/json')
                ->withStatus(303)
                ->withAddedHeader('Location', $YOUR_DOMAIN . "public/doc_login");
        }

        $checkout_session = \Stripe\Checkout\Session::create([
            'billing_address_collection' => 'required',
            'tax_id_collection' => [
                'enabled' => true,
            ],
            'shipping_address_collection' => [
                'allowed_countries' => ['IT'],
            ],
            'line_items' => [[
                # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                'price' => 'price_1Mo53YLVkLZLUpfopKyUMs0Q',
                'quantity' => 1,
            ]],
            'mode' => 'subscription',
            'success_url' => $YOUR_DOMAIN . 'pages/doctor_detail/success',
            'cancel_url' => $YOUR_DOMAIN . 'pages/doctor_detail/cancel',
            'automatic_tax' => [
                'enabled' => true,
            ],
            'consent_collection' => [
                'terms_of_service' => 'required',
            ],
            'client_reference_id' => $_SESSION['user_id'],
            'customer_email' => $_SESSION['email'],
            'metadata' => [
                'name'       => $_SESSION['fname'] . " " . $_SESSION['lname'],
                'user_email' => $_SESSION['email']
            ],
            'phone_number_collection' => ['enabled' => true],
            'allow_promotion_codes' => true,
        ]);

        header("HTTP/1.1 303 See Other");
        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus(303)
            ->withAddedHeader('Location', $checkout_session->url);
    }
}
