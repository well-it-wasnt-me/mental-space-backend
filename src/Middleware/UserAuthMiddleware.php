<?php

namespace App\Middleware;

use App\Moebius\Payments;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Routing\RouteContext;

/**
 * Class UserAuthMiddleware
 * @package App\Middleware
 */
final class UserAuthMiddleware implements MiddlewareInterface
{
    /**
     * @var ResponseFactoryInterface */
    private $responseFactory;
    /**
     * @var SessionInterface */
    private $session;
    public function __construct(ResponseFactoryInterface $responseFactory, SessionInterface $session)
    {
        $this->responseFactory = $responseFactory;
        $this->session = $session;
    }
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($this->session->get('user_id')) {
            // User is logged in
            return $handler->handle($request);
        }


        // User is not logged in. Redirect to login page.
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('public_doc_login');
        return $this->responseFactory->createResponse() ->withStatus(302)
            ->withHeader('Location', $url);
    }
}
