<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Action\Files;

use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;

final class FileDownloadAction
{

    private Responder $responder;

    function __construct(Responder $responder)
    {
        $this->responder = $responder;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface      $response
    ): ResponseInterface {

        $userId =  $request->getAttribute('uid');

        $fileName = $request->getParsedBody();

        if (empty($userId)) {
            return $this->responder
                ->withJson($response, ['status' => 'error', 'message' => __('User Not Found, who are you ?')])
                ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
        }



        $filePath = __DIR__ . "/../../../data/$userId/" . $fileName['file_name'];

        if (!is_file($filePath)) {
            return $this->responder
                ->withJson($response, ['status' => 'success', 'message'=>__('File non trovato')])
                ->withStatus(StatusCodeInterface::STATUS_OK);
        }

        return $this->responder
                ->withHeader('Content-Type', 'application/octet-stream')
                ->withHeader('Content-Disposition', 'attachment; filename=' . $fileName['file_name'])
                ->withAddedHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                ->withHeader('Cache-Control', 'post-check=0, pre-check=0')
                ->withHeader('Pragma', 'no-cache')
                ->withBody((new \Slim\Psr7\Stream(fopen($filePath, 'rb'))));
    }
}
