<?php

namespace App\Action\Reports;

use App\Domain\Reports\Service\ReportAdd;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;

final class ReportNewAction
{

    private string $tempDirectory = __DIR__ . '/../../../tmp/upload';
    private string $storageDirectory = __DIR__ . '/../../../data';
    private ReportAdd $creator;
    private Responder $responder;

    /**
     * @param ReportAdd $reportAdd Report add
     * @param Responder $responder Responder
     */
    function __construct(ReportAdd $reportAdd, Responder $responder)
    {
        $this->creator = $reportAdd;
        $this->responder = $responder;
    }


    /**
     * Action.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     *
     * @return ResponseInterface The response
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface      $response
    ): ResponseInterface {

        $data = (array)$request->getParsedBody();
        $directory = $this->storageDirectory;
        $uploadedFiles = $request->getUploadedFiles();

        // handle single input with single file upload
        $uploadedFile = $uploadedFiles['photo'];
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $filename = $this->moveUploadedFile($directory, $uploadedFile);
            $data['photo'] = $filename;
            $report_id = $this->creator->addReport($data);
            if (!is_int($report_id)) {
                return $this->responder
                    ->withJson($response, ['status' => 'error', 'message' => __('Error while inserting report')])
                    ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
            }
            return $this->responder
                ->withJson($response, ['status' => 'success','report_id' => $report_id])
                ->withStatus(StatusCodeInterface::STATUS_CREATED);
        } else {
            return $this->responder
                ->withJson($response, ['status' => 'error','message' => __('Error while uploading photo')])
                ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
        }
    }

    /**
     * Moves the uploaded file to the upload directory and assigns it a unique name
     * to avoid overwriting an existing uploaded file.
     *
     * @param string $directory The directory to which the file is moved
     * @param UploadedFileInterface $uploadedFile The file uploaded file to move
     *
     * @return string The filename of moved file
     */
    private function moveUploadedFile(string $directory, UploadedFileInterface $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);

        // see http://php.net/manual/en/function.random-bytes.php
        $basename = bin2hex(random_bytes(8));
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }
}
