<?php
/*
 * Mental Space Project - Creative Commons License
 */


namespace App\Action\Pages;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;

final class ListSmartboxAction
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

        $this->renderer->addAttribute('css', [
            '/app-assets/vendors/css/forms/select/select2.min.css',
            '/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css',
            '/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css',
            '/app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css',
            '/app-assets/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css',
        ]);

        $this->renderer->addAttribute('js', [
            '/app-assets/vendors/js/forms/select/select2.full.min.js',
            '/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js',
            '/app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js',
            '/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js',
            '/app-assets/vendors/js/tables/datatable/responsive.bootstrap5.js',
            '/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js',
            '/app-assets/vendors/js/tables/datatable/jszip.min.js',
            '/app-assets/vendors/js/tables/datatable/pdfmake.min.js',
            '/app-assets/vendors/js/tables/datatable/vfs_fonts.js',
            '/app-assets/vendors/js/tables/datatable/buttons.html5.min.js',
            '/app-assets/vendors/js/tables/datatable/buttons.print.min.js',
            '/app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js',
            '/app-assets/vendors/js/forms/validation/jquery.validate.min.js',
            '/app-assets/js/scripts/pages/app-smartbox-list.js',
        ]);

        return $this->renderer->render($response, 'awp/list.php');
    }
}
