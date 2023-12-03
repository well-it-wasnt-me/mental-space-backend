<?php

namespace App\Action\Pages;

use App\Domain\Consulti\Repository\ConsultRepository;
use App\Domain\Patients\Repository\PatientsRepository;
use App\Domain\Reports\Repository\ReportRepository;
use App\Domain\Tests\Repository\TestsRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;

final class ConsultoPageAction
{
    /**
     * @var PhpRenderer */
    private $renderer;
    private $repository;
    private $consulti;
    private $reportRepository;
    private $testRepository;

    public function __construct(PhpRenderer $renderer, PatientsRepository $repository, ConsultRepository $consultiRepository, ReportRepository $reportRepository, TestsRepository $testsRepository)
    {
        $this->renderer = $renderer;
        $this->repository = $repository;
        $this->consulti = $consultiRepository;
        $this->reportRepository = $reportRepository;
        $this->testRepository = $testsRepository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {

        if (!$this->consulti->checkCode($args['codice'])) {
            return $this->renderer->render($response, 'errors/not_found.php');
        }

        $this->renderer->setLayout('layout/consulto.php');

        $this->renderer->addAttribute('css', [
            '/app-assets/vendors/css/forms/select/select2.min.css',
            '/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css',
            '/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css',
            '/app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css',
            '/app-assets/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css',
            '/app-assets/css/pages/ui-feather.css',
            '/app-assets/vendors/css/editors/quill/katex.min.css',
            '/app-assets/vendors/css/editors/quill/monokai-sublime.min.css',
            '/app-assets/vendors/css/editors/quill/quill.snow.css',
            'https://fonts.googleapis.com/css2?family=Inconsolata&amp;family=Roboto+Slab&amp;family=Slabo+27px&amp;family=Sofia&amp;family=Ubuntu+Mono&amp;display=swap',
            '/app-assets/css/plugins/forms/form-quill-editor.css',
        ]);

        $this->renderer->addAttribute('js', [
            '/app-assets/vendors/js/forms/select/select2.full.min.js',
            '/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js',
            '/app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js',
            '/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js',
            '/app-assets/vendors/js/tables/datatable/responsive.bootstrap5.js',
            '/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js',
            '/app-assets/vendors/js/tables/datatable/jszip.min.js',
            '/app-assets/vendors/js/tables/datatable/pdfmake.min.js',
            '/app-assets/vendors/js/tables/datatable/vfs_fonts.js',
            '/app-assets/vendors/js/tables/datatable/buttons.html5.min.js',
            '/app-assets/vendors/js/tables/datatable/buttons.print.min.js',
            '/app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js',
            '/app-assets/vendors/js/extensions/sweetalert2.all.min.js',
            '/app-assets/vendors/js/extensions/polyfill.min.js',
            '/app-assets/js/scripts/pages/modal-edit-smartbox.js',
            '/app-assets/js/scripts/moment/moment.min.js',
            '/app-assets/js/scripts/moment/moment-with-locales.min.js',
            'https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js',
            '/app-assets/vendors/js/editors/quill/katex.min.js',
            '/app-assets/vendors/js/editors/quill/highlight.min.js',
            '/app-assets/vendors/js/editors/quill/quill.min.js',
            '/app-assets/js/scripts/forms/form-quill-editor.js',
            '/app-assets/js/scripts/pages/patient-detail.js',
            '/app-assets/js/scripts/components/components-popovers.js',
            '/app-assets/js/scripts/components/mutation.js',
            '/app-assets/js/scripts/pages/consulto.js',


        ]);

        $paz_id = $this->consulti->retrievePazID($args['codice']);
        $uid = $this->consulti->retrieveUserID($args['codice']);
        $patientData = $this->repository->consultoPatientDetail($paz_id);

        $diario_list = $this->repository->listDiary($uid);
        $diario = "";
        foreach ($diario_list as $key => $val) {
            $diario .= '<div class="card accordion-item">' .
                '   <h2 class="accordion-header" id="paymentOne">' .
                '       <button class="accordion-button collapsed" data-bs-toggle="collapse" role="button" data-bs-target="#asd' . $val['diary_id'] . '" aria-expanded="false" aria-controls="asd' . $val['diary_id'] . '">' .
                '    ' . $val['creation_date'] .
                '       </button>' .
                '   </h2>' .
                '' .
                '   <div id="asd' . $val['diary_id'] . '" class="collapse accordion-collapse" aria-labelledby="paymentOne" data-bs-parent="#faq-payment-qna">' .
                '       <div class="accordion-body">' .
                '   ' . $val['content'] .
                '    </div>' .
                '   </div>' .
                '</div>';
        }

        $drugs = $this->repository->listPharmPat($paz_id, true);
        $farmaci = "";
        foreach ($drugs as $key => $val) {
            $farmaci .= '<li>'. $val['principio_attivo'].' - '. $val['denom'] .'</li>';
        }
        $moods = $this->repository->last10moods($uid);
        $mood = "";
        foreach ($moods as $key => $val) {
            $color = "";
            if ($val['value'] === 'OTTIMO') {
                $color = "timeline-point-info";
            } elseif ($val['value'] === 'BUONO') {
                $color = "timeline-point-primary";
            } elseif ($val['value'] === 'STABILE') {
                $color = "timeline-point-secondary";
            } elseif ($val['value'] === 'BASSO') {
                $color = "timeline-point-warning";
            } elseif ($val['value'] === 'MOLTO DEPRESSO') {
                $color = 'timeline-point-danger';
            } else {
                $color = "";
            }
            $mood .= '<li class="timeline-item">' .
                '   <span class="timeline-point timeline-point-indicator ' . $color .  '"></span>' .
                '   <div class="timeline-event">' .
                '       <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">' .
                '       <h6>' . $val['value'] . '</h6>' .
                '       <span class="timeline-event-time me-1">' . $val['effective_datetime'] . '</span>' .
                '   </div>' .
                '   <p>' . $val['warning_sign'] . '</p>' .
                '</div>' .
                '</li>';
        }

        $annot = $this->repository->listAnnotation($paz_id, true);
        $annotazioni = "";
        foreach ($annot as $key => $val) {
            $annotazioni .= '<div class="card accordion-item">' .
                '   <h2 class="accordion-header" id="paymentOnes">' .
                '       <button class="accordion-button collapsed" data-bs-toggle="collapse" role="button" data-bs-target="#as' . $val['ann_id'] . '" aria-expanded="false" aria-controls="as' . $val['ann_id'] . '">' .
                '    ' . $val['creation_date'] .
                '       </button>' .
                '   </h2>' .
                '' .
                '   <div id="as' . $val['ann_id'] . '" class="collapse accordion-collapse" aria-labelledby="paymentOnes" data-bs-parent="#faq-payment-qna">' .
                '       <div class="accordion-body">' .
                '   ' . $val['annotazione'] .
                '    </div>' .
                '   </div>' .
                '</div>';
        }

        $stats = $this->reportRepository->getUserReport($uid);
        //['diario' => $diary, 'comportamento' => $comportamento, 'emozioni' => ['stat'=>$emozioni, 'average'=> $avg]];
        $statDiario = "";
        foreach ($stats['diario'] as $key => $val) {
            $statDiario .= "<b>Post Immessi</b> " . $val['tot_post'] ." <br>";
            $statDiario .= "<b>Data Raggruppamento</b> " . $val['post_ts'] ." <br><br>";
        }

        $statComportamento = "";
        foreach ($stats['comportamento'] as $key => $val) {
            $statComportamento .= "<b>Test Compilati</b> " . $val['tot_test'] ." <br>";
            $statComportamento .= "<b>Data Raggruppamento</b> " . $val['compilazione_ts'] ." <br><br>";
        }

        $emozioni = "";
        foreach ($stats['emozioni']['stat'] as $key => $val) {
            $emozioni .= "<b>Test Compilati</b> " . $val['tot_test'] ." <br>";
            $emozioni .= "<b>Data Raggruppamento</b> " . $val['compilazione_ts'] ." <br><br>";
        }

        $emozioniAvg = "";
        foreach ($stats['emozioni']['average'] as $key => $val) {
            $emozioniAvg .= "<b>Data Compilazione</b> " . $val['data_compilazione'] ." <br>";
            $emozioniAvg .= "<b>Rabbia</b> " . $val['rabbia'] ." <br>";
            $emozioniAvg .= "<b>Paura</b> " . $val['paura'] ." <br>";
            $emozioniAvg .= "<b>Gioia</b> " . $val['gioia'] ." <br>";
            $emozioniAvg .= "<b>Colpa</b> " . $val['colpa'] ." <br>";
            $emozioniAvg .= "<b>Tristezza</b> " . $val['tristezza'] ." <br>";
            $emozioniAvg .= "<b>Vergogna</b> " . $val['vergogna'] ." <br>";
            $emozioniAvg .= "<b>Sofferenza Fisica ed Emotiva</b> " . $val['sofferenza_fisica_emotiva'] ." <br>";
            $emozioniAvg .= "<b>Abilità messe in pratica</b> " . $val['abilita_messe_in_pratica'] ." <br>";
            $emozioniAvg .= "<b>Intenzione Abbandono terapia</b> " . $val['intenzione_abbandono_terapia'] ." <br>";
            $emozioniAvg .= "<b>Fiducia nel cambiamento</b> " . $val['fiducia_cambiamento'] ." <br><br>";
        }

        $phq = $this->testRepository->listPhq9Test($uid);
        $li = "";
        foreach ($phq as $key => $val) {
            $li .= "<li>". $val['data_compilazione'] ."</li>";
            $li .= $this->convertResultPhq($val['result']) . "<br><br>";
        }

        $comportamentiImpulsivi = $this->testRepository->listBehaviourTest($uid);
        $cmp = "";
        foreach ($comportamentiImpulsivi as $key => $val) {
            foreach ($val as $a => $b) {
                if ($a != "cmp_id" && $a != "paz_id") {
                    $cmp .= $a . " - " . $b . "<br>";
                }
            }
            $cmp .= "<hr>";
        }

        return $this->renderer->render($response, 'consulto/home.php', [
            'patient' => $patientData[0],
            'diario' => empty($diario) ? 'Non ha scritto nulla negli ultimi 7 giorni':$diario,
            'lista_farmaci' => $farmaci,
            'registrazioni_mood' => $mood,
            'annotation' => $annotazioni,
            'stats' => [
                'diario' => empty($statDiario) ? 'Non ha scritto nulla negli ultimi 7 giorni':$statDiario,
                'comportamento' => $statComportamento,
                'emozioni_stat' => $emozioni,
                'emozioni_avg' => $emozioniAvg
            ],
            'phq' => $li,
            'compImp' => $cmp
        ]);
    }

    function convertResultPhq($result)
    {
        if ($result < 5) {
            return "Depressione Non rilevata";
        } elseif ($result >= 5 && $result <= 9) {
            return "Depressione sottosoglia";
        } elseif ($result >= 10 && $result <= 14) {
            return "Depressione Maggiore lieve";
        } elseif ($result >= 15 && $result <= 19) {
            return "Depressione Maggiore Moderata";
        } elseif ($result >= 20) {
            return "Depression Maggiore Severa";
        } else {
            return "Errore, valore non presente in scale: $result";
        }
    }
}
