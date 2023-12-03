<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Action\Auth;

use App\Routing\JwtAuth;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Token\Builder;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;
use App\Domain\Auth\UserAuth;

/**
 * Class DocLoginSubmitAction
 * @package App\Action\Auth
 */
final class UserLoginSubmitAction
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var UserAuth
     */
    private UserAuth $userAuth;

    private JwtAuth $jwtAuth;

    /**
     * DocLoginSubmitAction constructor.
     * @param SessionInterface $session Sessiona Management
     * @param UserAuth $userAuth User Authentication
     */
    public function __construct(SessionInterface $session, UserAuth $userAuth, JwtAuth $jwtAuth)
    {
        $this->session = $session;
        $this->userAuth = $userAuth;
        $this->jwtAuth = $jwtAuth;
    }

    /**
     * @param ServerRequestInterface $request Request
     * @param ResponseInterface $response Response
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $username = (string)($data['username'] ?? '');
        $password = (string)($data['password'] ?? '');
        $role = (string)($data['role'] ?? '');

        $userData = $this->userAuth->authenticate_paz($username, $password, $role);
        // Clear all flash messages
        $flash = $this->session->getFlash();
        $flash->clear();
        // Get RouteParser from request to generate the urls
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

        if ($userData) {
        // Login successfully
        // Clears all session data and regenerate session ID
            $this->session->destroy();
            $this->session->start();
            $this->session->regenerateId();
            $this->session->set('user_id', $userData['user_id']);
            $this->session->set('role', $userData['role']);
            $this->session->set('fname', $userData['f_name']);
            $this->session->set('lname', $userData['l_name']);
            $this->session->set('locale', $userData['locale']);
            $this->session->set('email', $userData['email']);
            $flash->add('success', 'Login successfully');

            set_language($userData['locale']);

            $token = $this->jwtAuth->createJwt(
                [
                    'uid' => $userData['user_id'],
                    'email' => $userData['email'],
                    'f_name' => $userData['f_name'],
                    'l_name' => $userData['l_name'],
                    'pic' => get_gravatar($userData['email']),
                    'locale' => $userData['locale'],
                    'reg_date' => $userData['reg_date'],
                    'account_status' => $userData['account_status'],
                    'cf' => $userData['cf'],
                    'dob' => $userData['dob'],
                    'height' => $userData['height'],
                    'weight' => $userData['weight'],
                    'telefono' => $userData['telefono'],
                    'em_nome' => $userData['em_nome'],
                    'em_telefono' => $userData['em_telefono'],
                    'address' => $userData['address']

                ]
            );

            // Redirect to protected page
            $response = $response->withHeader('Content-Type', 'application/json');
            $response->getBody()->write((string)json_encode(['status'=>'success', 'access_token'=>$token, 'expires_in' => $this->jwtAuth->getLifetime(), 'token_type' => 'Bearer'], JSON_THROW_ON_ERROR));
            return $response->withStatus(201);
        } else {
            $flash->add('error', 'Login failed!');
            $response = $response->withHeader('Content-Type', 'application/json');
            $response->getBody()->write((string)json_encode(['status'=>'error', 'message'=> 'Invalid Login'], JSON_THROW_ON_ERROR));
            return $response->withStatus(401);
        }
    }
}
