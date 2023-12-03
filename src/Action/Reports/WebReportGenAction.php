<?php

namespace App\Action\Reports;

use App\Domain\Reports\Repository\ReportRepository;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class WebReportGenAction
{
    private Responder $responder;
    private ReportRepository $repository;
    function __construct(Responder $responder, ReportRepository $repository)
    {
        $this->repository = $repository;
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

        $data = $request->getParsedBody();
        $tables = json_decode($data['tables'], true);
        $raggr = json_decode($data['raggr'], true);
        $assistiti = json_decode($data['assistiti'], true);
        $elenco_repo ="";
        $result = $this->repository->generazioneReport($tables, $raggr, $assistiti);

        foreach ($tables as $key => $val) {
            $elenco_repo .= '<tr>
                                <th align="left" style="padding-bottom: 8px;">
                                    <p>'.$val.'</p>
                                </th>
                            </tr>';
        }

        $htmlReport = "";

        if (!empty($result['diario'])) {
            $htmlReport .= "<h1>Analisi del Diario</h1>
                            <h2>Parole più usate</h2>
<ul class=\"cloud\" role=\"navigation\" aria-label=\"Word Cloud\">";

            foreach ($result['diario'] as $key => $val) {
                $htmlReport .= "<li><a href=\"#\" data-weight=\"".$val['total']."\">".$val['value']." Totale: " . $val['total']."</a></li>";
            }

            $htmlReport .= "</ul>";
        } elseif (!empty($result['diagnosi'])) {
        }

        $cover_content = file_get_contents(__DIR__ . '/../../../data/pdf_template/report_cover_template');
        $report_content = file_get_contents(__DIR__ . '/../../../data/pdf_template/report_content');

        $cover_content = str_replace('{DOC_NAME}', $_SESSION['fname'], $cover_content);
        $cover_content = str_replace('{DOC_SURNAME}', $_SESSION['lname'], $cover_content);
        $cover_content = str_replace('{ELENCO_REPORT}', $elenco_repo, $cover_content);
        $cover_content = str_replace('{FULL_DATE}', date("d/m/y H:i"), $cover_content);

        $report_content = str_replace('{CONTENT}', $htmlReport, $report_content);

        $pdf = new \Mpdf\Mpdf();
        $pdf->WriteHTML($cover_content);
        $pdf->AddPage();
        $pdf->WriteHTML($report_content);
        ob_end_clean();

        if (!is_dir(__DIR__ .'/../../../data/' . $_SESSION['user_id'])) {
            mkdir(__DIR__ .'/../../../data/' . $_SESSION['user_id']);
        }
        if (!is_dir(__DIR__ .'/../../../data/' . $_SESSION['user_id']. "/report")) {
            mkdir(__DIR__ .'/../../../data/' . $_SESSION['user_id']."/report");
        }

        $file_name = "MS-REPORT-" . date("dmYHis"). ".pdf";
        $content = $pdf->Outputfile(__DIR__ . '/../../../data/' . $_SESSION['user_id'] . "/report/$file_name");
        $result['file_name'] = $file_name;

        return $this->responder
            ->withJson($response, $result)
            ->withStatus(StatusCodeInterface::STATUS_OK);
    }
}
