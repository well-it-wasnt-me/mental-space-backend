<?php
/*
 * Mental Space Project - Creative Commons License
 */


namespace App\Action\Pages;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;

final class ReportsAction
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

        $id = $request->getParsedBody();

        $this->renderer->setLayout('layout/layout.php');

        $this->renderer->addAttribute('css', [
            '/app-assets/vendors/css/forms/wizard/bs-stepper.min.css',
            '/app-assets/vendors/css/forms/select/select2.min.css',
            '/app-assets/css/plugins/forms/form-validation.css',
            '/app-assets/css/plugins/forms/form-wizard.css',
            '/assets/css/style.css'
        ]);

        $this->renderer->addAttribute('js', [
            '/app-assets/vendors/js/forms/wizard/bs-stepper.min.js',
            '/app-assets/vendors/js/forms/select/select2.full.min.js',
            '/app-assets/vendors/js/forms/validation/jquery.validate.min.js',
            '/app-assets/js/scripts/forms/reports.js'
        ]);

        return $this->renderer->render($response, 'doctor/reports.php');
    }
}
