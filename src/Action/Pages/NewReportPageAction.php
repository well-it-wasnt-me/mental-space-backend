<?php

namespace App\Action\Pages;

use App\Moebius\Definition;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;

final class NewReportPageAction
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

        $this->renderer->setLayout('layout/layout_reporter.php');
        $this->renderer->addAttribute('css', [
            '/assets/js/plugins/sweetalert2/sweetalert2.css'
        ]);

        $this->renderer->addAttribute('js', [
            '/assets/js/pages/new_report.js',
            '/assets/js/plugins/sweetalert2/sweetalert2.all.js',
        ]);

        return $this->renderer->render($response, 'reports/new_reports.php');
    }
}
