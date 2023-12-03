<?php

namespace App\Action\Pages;

use App\Domain\Doctors\Repository\DoctorRepository;
use App\Moebius\Definition;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;

final class MessagesDocPageAction
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

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {

            $this->renderer->setLayout('layout/layout.php');
            $this->renderer->addAttribute('css', [
                "/app-assets/css/pages/app-chat.css",
                "/app-assets/css/pages/app-chat-list.css",
            ]);

            $this->renderer->addAttribute('js', [
                "/app-assets/js/scripts/pages/app-chat.js",
                '/app-assets/vendors/js/extensions/sweetalert2.all.min.js'
            ]);


            $docDetail = $this->repository->doctorDetail();

            return $this->renderer->render($response, 'doctor/messages.php', $docDetail[0]);
    }
}
