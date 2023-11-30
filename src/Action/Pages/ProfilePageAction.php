<?php

namespace App\Action\Pages;

use App\Moebius\Definition;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;

final class ProfilePageAction
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
        if( $_SESSION['role'] == Definition::REPORTER ) {
            $this->renderer->setLayout('layout/layout_reporter.php');

        } else {
            $this->renderer->setLayout('layout/layout.php');
        }

        $this->renderer->addAttribute('css', [

        ]);

        $this->renderer->addAttribute('js', [
            '/assets/js/pages/profile.js',

        ]);

        return $this->renderer->render($response, 'home/profile.php');
    }

}
