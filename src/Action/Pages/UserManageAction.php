<?php
/*
 * Mental Space Project - Creative Commons License
 */


namespace App\Action\Pages;

use App\Moebius\Definition;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;

final class UserManageAction
{
    /**
     * @var PhpRenderer
     */
    private $renderer;

    public function __construct(PhpRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {

        $this->renderer->setLayout('layout/layout.php');

        //$this->renderer->addAttribute('css', [
        //    '//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css',
        //]);

        $this->renderer->addAttribute('js', [
            './assets/js/libs/datatable-btns.js?ver=3.0.0',
            './js/pages/users/manage.js',
        ]);

        return $this->renderer->render($response, 'users/manage.php');
    }
}
