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

final class FileListAction
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

        if (empty($userId)) {
            return $this->responder
                ->withJson($response, ['status' => 'error', 'message' => __('User Not Found, who are you ?')])
                ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        $directory = __DIR__ . "/../../../data/$userId";

        $listaFiles = scandir($directory);
        $listaFiles = array_diff($listaFiles, ['.', '..']);

        return $this->responder
            ->withJson($response, ['status' => 'success', 'files' => $listaFiles])
            ->withStatus(StatusCodeInterface::STATUS_OK);
    }

    private function moveUploadedFile(string $directory, UploadedFileInterface $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
        $filename = $uploadedFile->getClientFilename() . "-" . sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }
}
