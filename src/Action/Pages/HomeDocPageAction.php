<?php

namespace App\Action\Pages;

use App\Moebius\Definition;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;

final class HomeDocPageAction
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
            /*
            $this->renderer->addAttribute('css', [
                '/assets/js/plugins/datatables-bs5/dataTables.bootstrap5.css',
                '/assets/js/plugins/datatables-buttons-bs5/buttons.bootstrap5.min.css',
                '/assets/js/plugins/sweetalert2/sweetalert2.css'
            ]);*/

            $this->renderer->addAttribute('js', [
                '../../../app-assets/vendors/js/forms/select/select2.full.min.js',
                '../app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js',
                '../app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js',
                "../app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js",
    "../../../app-assets/vendors/js/tables/datatable/responsive.bootstrap5.js",
    "../../../app-assets/vendors/js/tables/datatable/datatables.buttons.min.js",
    "../../../app-assets/vendors/js/tables/datatable/jszip.min.js",
    "../../../app-assets/vendors/js/tables/datatable/pdfmake.min.js",
    "../../../app-assets/vendors/js/tables/datatable/vfs_fonts.js",
    "../../../app-assets/vendors/js/tables/datatable/buttons.html5.min.js",
    "../../../app-assets/vendors/js/tables/datatable/buttons.print.min.js",
    "../../../app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js",
    "../../../app-assets/vendors/js/forms/validation/jquery.validate.min.js",
    "../../../app-assets/vendors/js/forms/cleave/cleave.min.js",
    "../../../app-assets/vendors/js/forms/cleave/addons/cleave-phone.us.js",
    "../../../app-assets/js/scripts/moment/moment.min.js",
                '../app-assets/js/scripts/pages/app-user-list.js',
            ]);

            return $this->renderer->render($response, 'home/doctor.php');

    }
}
