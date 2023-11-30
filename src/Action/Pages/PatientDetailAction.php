<?php
/*
 * Mental Space Project - Creative Commons License
 */


namespace App\Action\Pages;

use App\Domain\Patients\Repository\PatientsRepository;
use App\Moebius\Krypton;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;

final class PatientDetailAction
{
    /**
     * @var PhpRenderer
     */
    private $renderer;
    private PatientsRepository $repository;

    public function __construct(PhpRenderer $renderer, PatientsRepository $repository)
    {
        $this->renderer = $renderer;
        $this->repository = $repository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {

        $id = $request->getParsedBody();

        $this->renderer->setLayout('layout/layout.php');

        $this->renderer->addAttribute('css', [
            '/app-assets/vendors/css/forms/select/select2.min.css',
            '/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css',
            '/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css',
            '/app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css',
            '/app-assets/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css',
            '/app-assets/css/pages/ui-feather.css',
            '/app-assets/vendors/css/editors/quill/katex.min.css',
            '/app-assets/vendors/css/editors/quill/monokai-sublime.min.css',
            '/app-assets/vendors/css/editors/quill/quill.snow.css',
            'https://fonts.googleapis.com/css2?family=Inconsolata&amp;family=Roboto+Slab&amp;family=Slabo+27px&amp;family=Sofia&amp;family=Ubuntu+Mono&amp;display=swap',
            '/app-assets/css/plugins/forms/form-quill-editor.css',
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
            '/app-assets/vendors/js/extensions/sweetalert2.all.min.js',
            '/app-assets/vendors/js/extensions/polyfill.min.js',
            '/app-assets/js/scripts/pages/modal-edit-smartbox.js',
            '/app-assets/js/scripts/moment/moment.min.js',
            '/app-assets/js/scripts/moment/moment-with-locales.min.js',
            'https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js',
            '/app-assets/vendors/js/editors/quill/katex.min.js',
            '/app-assets/vendors/js/editors/quill/highlight.min.js',
            '/app-assets/vendors/js/editors/quill/quill.min.js',
            '/app-assets/js/scripts/forms/form-quill-editor.js',
            '/app-assets/js/scripts/pages/patient-detail.js',
            '/app-assets/js/scripts/components/components-popovers.js',


        ]);

        $patient_detail = $this->repository->patientDetail((int)$args['paz_id']);

        if ( !$patient_detail || empty($patient_detail) ) {
            return $this->renderer->render($response, 'errors/not_found.php');
        }
        $krypton = new Krypton();

        //$patient_detail[0]['notes'] = $krypton->decrypt($patient_detail[0]['notes']);

        return $this->renderer->render($response, 'patients/view.php', $patient_detail[0]);
    }
}
