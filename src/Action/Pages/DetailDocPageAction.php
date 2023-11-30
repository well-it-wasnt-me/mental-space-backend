<?php

namespace App\Action\Pages;

use App\Domain\Doctors\Repository\DoctorRepository;
use App\Moebius\Definition;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;

final class DetailDocPageAction
{
    /**
     * @var PhpRenderer */
    private $renderer;
    private DoctorRepository $repository;

    public function __construct(PhpRenderer $renderer, DoctorRepository $repository)
    {
        $this->renderer = $renderer;
        $this->repository = $repository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {

            $this->renderer->setLayout('layout/layout.php');
            $this->renderer->addAttribute('css', [
                '/app-assets/css/plugins/forms/form-validation.css'
            ]);

            $this->renderer->addAttribute('js', [
                //'https://js.stripe.com/v3/',
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
                '/app-assets/vendors/js/forms/select/select2.full.min.js',
                '/app-assets/vendors/js/extensions/sweetalert2.all.min.js',
                '/app-assets/vendors/js/forms/validation/jquery.validate.min.js',
                '/app-assets/vendors/js/forms/cleave/cleave.min.js',
                '/app-assets/vendors/js/forms/cleave/addons/cleave-phone.it.js',
                '/app-assets/js/scripts/pages/page-account-settings-account.js',
            ]);


            $docDetail = $this->repository->doctorDetail();
            if(isset($args['esito'])){
                $docDetail[0]['esito'] = $args['esito'];
            }
            return $this->renderer->render($response, 'doctor/view.php', $docDetail[0]);

    }
}
