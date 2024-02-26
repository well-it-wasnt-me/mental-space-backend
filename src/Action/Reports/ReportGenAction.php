<?php

namespace App\Action\Reports;

use App\Domain\Pharm\Repository\PharmRepository;
use App\Domain\Pharm\Service\PharmList;
use App\Domain\Reports\Service\ReportAdd;
use App\Domain\Users\Repository\UserRepository;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use http\Client\Curl\User;
use Mpdf\Mpdf;
use PHPMailer\PHPMailer\PHPMailer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;

final class ReportGenAction
{
    private Responder $responder;
    private UserRepository $userRepository;
    private PharmRepository $pharmList;
    function __construct(Responder $responder, PharmRepository $pharmList, UserRepository $userRepository)
    {
        $this->pharmList = $pharmList;
        $this->userRepository = $userRepository;
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

        $uid = $request->getAttribute('uid');
        $userPills = $this->pharmList->userDrug($uid);
        $userInfo = $this->userRepository->getUserById($uid);
        $body = file_get_contents(__DIR__ . '/../../../data/pdf_template/pill_template');
        $html = "";

        foreach ($userPills as $key => $val) {
            $html .= "<tr><td style=\"font-family: 'Montserrat',Arial,sans-serif; font-size: 14px; padding-top: 10px; padding-bottom: 10px; width: 80%;\" width=\"80%\">
                                    ". $val['principio_attivo'] . " - " . $val['denom'] ."
                                  </td>
                                  <td align=\"right\" style=\"font-family: 'Montserrat',Arial,sans-serif; font-size: 14px; text-align: right; width: 20%;\" width=\"20%\">
                                    ". $val['prezzo']."
                                  </td></tr>";
        }

        $fullName = $userInfo['name'] . " " . $userInfo['surname'];

        $new_content = str_replace("{ELENCO_FARMACI}", $html, $body);
        $new_content = str_replace("{USER_FULLNAME}", $fullName, $new_content);

        $pdf = new \Mpdf\Mpdf();
        $pdf->WriteHTML($new_content);
        ob_end_clean();
        $content = $pdf->Outputfile(__DIR__ . '/../../../data/' . $uid . "/my_pills.pdf");

        $mail = new PHPMailer(true);
        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = env('MAIL_SMTP');                     //Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   //Enable SMTP authentication
            $mail->Username = env('MAIL_USER');                     //SMTP username
            $mail->Password = env('MAIL_PASS');                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom(env('MAIL_FROM'), 'Mental Space');
            $mail->addAddress($userInfo['email']);

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Elenco dei tuoi Farmaci';
            $mail->Body = $new_content;
            $mail->addAttachment(__DIR__ . '/../../../data/' . $uid . "/my_pills.pdf", "my_pills.pdf");
            $mail->send();

            return $this->responder->withJson($response, ['status' => 'success', 'message' => 'Report inviato alla tua E-Mail'])
                ->withStatus(StatusCodeInterface::STATUS_OK);
        } catch (\Exception $e) {
            return $this->responder
                ->withJson($response, ['status' => 'error', 'messsage' => $e->getMessage()])
                ->withStatus(StatusCodeInterface::STATUS_OK);
        }
    }
}
