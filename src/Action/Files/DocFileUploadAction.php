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

final class DocFileUploadAction
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


        $uid = $request->getParsedBody();
        $userId =  $uid['user_id'];

        if (empty($userId)) {
            return $this->responder
                ->withJson($response, ['status' => 'error', 'message' => __('User Not Found, who are you ?')])
                ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        $uploadedFiles = $request->getUploadedFiles();

        if (!$uploadedFiles) {
            return $this->responder
                ->withJson($response, ['status' => 'error', 'message' => __("Hai dimenticato di inviare file")])
                ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        $uploadedFile = $uploadedFiles['file'];

        $directory = __DIR__ . "/../../../data/$userId";

        if (!is_dir($directory)) {
            mkdir($directory);
        }

        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $filename = $this->moveUploadedFile($directory, $uploadedFile);
            return $this->responder
                ->withJson($response, ['status' => 'success', 'message' => __("Caricato con successo")])
                ->withStatus(StatusCodeInterface::STATUS_OK);
        }

        return $this->responder
            ->withJson($response, ['status' => 'error', 'message' => __("Qualcosa è andato storto")])
            ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
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
