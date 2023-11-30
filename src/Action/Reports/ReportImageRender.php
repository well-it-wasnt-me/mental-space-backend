<?php

namespace App\Action\Reports;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\StreamFactory;

final class ReportImageRender
{

    /**
     * Action.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     * @param array<mixed> $args The routing arguments
     *
     * @return ResponseInterface The response
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {

        $file = __DIR__  . "/../../../data/" . $args['photo'] . "." . $args['extension'];
        if (!file_exists($file)) {
            echo "Image not found";
            return $response->withHeader('Content-Type', 'text/plain');
        }
        $image = file_get_contents($file);
        if ($image === false) {
            echo "Cant get image";
            return $response->withHeader('Content-Type', 'text/plain');
        }
        $mime = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $file);
        $response = $response->withHeader('Content-Type', $mime);

        // Output image as stream
        return $response->withBody((new StreamFactory())->createStream($image));
    }
}
