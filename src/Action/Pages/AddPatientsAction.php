<?php
/*
 * Mental Space Project - Creative Commons License
 */


namespace App\Action\Pages;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;

final class AddPatientsAction
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
            '/app-assets/vendors/css/forms/wizard/bs-stepper.min.css',
            '/app-assets/vendors/css/forms/select/select2.min.css',
            '/app-assets/css/plugins/forms/form-validation.css',
            '/app-assets/css/plugins/forms/form-wizard.css',
            '/app-assets/vendors/css/editors/quill/katex.min.css',
            '/app-assets/vendors/css/editors/quill/monokai-sublime.min.css',
            '/app-assets/vendors/css/editors/quill/quill.snow.css',
            'https://fonts.googleapis.com/css2?family=Inconsolata&amp;family=Roboto+Slab&amp;family=Slabo+27px&amp;family=Sofia&amp;family=Ubuntu+Mono&amp;display=swap',
            '/app-assets/css/plugins/forms/form-quill-editor.css',
        ]);

        $this->renderer->addAttribute('js', [
            'https://maps.googleapis.com/maps/api/js?key=--INSER KEY HERE--&libraries=places',
            '/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js',
            '/app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js',
            '/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js',
            '/app-assets/vendors/js/tables/datatable/responsive.bootstrap5.min.js',
            '/app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js',
            '/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js',
            '/app-assets/vendors/js/tables/datatable/jszip.min.js',
            '/app-assets/vendors/js/tables/datatable/pdfmake.min.js',
            '/app-assets/vendors/js/tables/datatable/vfs_fonts.js',
            '/app-assets/vendors/js/tables/datatable/buttons.html5.min.js',
            '/app-assets/vendors/js/tables/datatable/buttons.print.min.js',
            '/app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js',
            '/app-assets/vendors/js/extensions/sweetalert2.all.min.js',
            /*'/app-assets/vendors/js/forms/validation/jquery.validate.min.js',*/
            '/app-assets/vendors/js/forms/select/select2.full.min.js',
            '/app-assets/vendors/js/forms/wizard/bs-stepper.min.js',
            '/app-assets/vendors/js/editors/quill/katex.min.js',
            '/app-assets/vendors/js/editors/quill/highlight.min.js',
            '/app-assets/vendors/js/editors/quill/quill.min.js',
            '/app-assets/js/scripts/forms/form-wizard.js',
            '/app-assets/js/scripts/forms/form-quill-editor.js',
            '/app-assets/js/scripts/pages/patient-add.js'


        ]);

        return $this->renderer->render($response, 'patients/add.php');
    }
}
