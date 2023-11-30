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

final class FaqPageAction
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
            '/app-assets/css/pages/page-faq.css',
        ]);

        $this->renderer->addAttribute('js', []);

        return $this->renderer->render($response, 'doctor/faq.php');
    }
}
