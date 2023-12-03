<?php

namespace App\Action\Pages;

use App\Moebius\Definition;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;

final class ReportsPageAction
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

            $this->renderer->setLayout('layout/layout.php');
            $this->renderer->addAttribute('css', [
                '/assets/js/plugins/datatables-bs5/dataTables.bootstrap5.css',
                '/assets/js/plugins/datatables-buttons-bs5/buttons.bootstrap5.min.css',
                '/assets/js/plugins/sweetalert2/sweetalert2.css'
            ]);

            $this->renderer->addAttribute('js', [
                '/assets/js/pages/reports.js',
                '/assets/js/plugins/datatables/jquery.dataTables.min.js',
                '/assets/js/plugins/datatables-bs5/dataTables.bootstrap5.js',
                '//cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js',
                '//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js',
                '//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js',
                '//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js',
                '//cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js',
                '/assets/js/plugins/sweetalert2/sweetalert2.all.js',
            ]);

            return $this->renderer->render($response, 'reports/reports.php');
    }
}
