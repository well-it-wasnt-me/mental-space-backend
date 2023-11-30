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

final class CalendarAction
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
            "/app-assets/vendors/css/vendors.min.css",
            "/app-assets/vendors/css/calendars/fullcalendar.min.css",
            "/app-assets/vendors/css/forms/select/select2.min.css",
            "/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css",
            "/app-assets/css/bootstrap.css",
            "/app-assets/css/bootstrap-extended.css",
            "/app-assets/css/colors.css",
            "/app-assets/css/components.css",
            "/app-assets/css/themes/dark-layout.css",
            "/app-assets/css/themes/bordered-layout.css",
            "/app-assets/css/themes/semi-dark-layout.css",

            "/app-assets/css/core/menu/menu-types/vertical-menu.css",
            "/app-assets/css/plugins/forms/pickers/form-flat-pickr.css",
            "/app-assets/css/pages/app-calendar.css",
            "/app-assets/css/plugins/forms/form-validation.css",
            "/assets/css/style.css",
        ]);

        $this->renderer->addAttribute('js', [
                '/app-assets/vendors/js/extensions/sweetalert2.all.min.js',
                "/app-assets/vendors/js/calendar/fullcalendar.min.js",
                "/app-assets/vendors/js/extensions/moment.min.js",
                "/app-assets/vendors/js/forms/select/select2.full.min.js",
                "/app-assets/vendors/js/forms/validation/jquery.validate.min.js",
                "/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js",
                '/app-assets/js/scripts/pages/app-calendar-events.js',
                '/app-assets/js/scripts/pages/app-calendar.js',

        ]);


        return $this->renderer->render($response, 'doctor/calendar.php');
    }
}
