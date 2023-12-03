<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Action\Doctors;

use App\Domain\Doctors\Service\DocUpdate;
use App\Domain\Patients\Repository\PatientsRepository;
use App\Domain\Users\Repository\UserRepository;
use App\Responder\Responder;
use Exception;
use Fig\Http\Message\StatusCodeInterface;
use PHPMailer\PHPMailer\PHPMailer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class InviteDoctorAction
{

    private UserRepository $repository;
    private PatientsRepository $patientsRepository;
    private Responder $responder;

    function __construct(UserRepository $repository, Responder $responder, PatientsRepository $patientsRepository)
    {
        $this->repository = $repository;
        $this->responder = $responder;
        $this->patientsRepository = $patientsRepository;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface      $response
    ): ResponseInterface {

        $userId =  $request->getAttribute('uid');
        $userData = $this->repository->getUserById($userId);

        if (empty($userData)) {
            return $this->responder
                ->withJson($response, ['status' => 'error', 'message' => __('User Not Found, who are you ?')])
                ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
        }
        $data = (array)$request->getParsedBody();
        if (empty($data)) {
            $data = json_decode(file_get_contents('php://input'), true);
        }

        if (empty($data)) {
            return $this->responder
                ->withJson($response, ['status' => 'error', 'message' => __('No Data Passed')])
                ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
        }


        $docData = $this->repository->getDocByEmail($data['doc_email']);

        if (empty($docData)) {
            $mail = new PHPMailer(true);
            try {
                //Server settings
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host = getenv('MAIL_SMTP');                     //Set the SMTP server to send through
                $mail->SMTPAuth = true;                                   //Enable SMTP authentication
                $mail->Username = getenv('MAIL_USER');                     //SMTP username
                $mail->Password = getenv('MAIL_PASS');                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom(getenv('MAIL_FROM'), 'Mental Space');
                $mail->addAddress($data['doc_email']);

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = __('Invite to enter in Mental Space');
                $mail_body = file_get_contents(__DIR__ . '/../../../data/mail_template/doctor_invitation');
                $search = ['{{PAZ_NOME}}', '{{PAZ_COGNOME}}', '{{PAZ_EMAIL}}', '{{PAZ_USER_ID}}'  ];
                $replace = [$userData['name'], $userData['surname'], $userData['email'], $userData['user_id']];
                $mail_body = str_replace($search, $replace, $mail_body);
                $mail->Body = $mail_body;
                $mail->send();
            } catch (Exception $e) {
                return $this->responder
                    ->withJson($response, ['status' => 'error', 'messsage' => $e->getMessage()])
                    ->withStatus(StatusCodeInterface::STATUS_OK);
            }

            return $this->responder
                ->withJson($response, ['status' => 'success'])
                ->withStatus(StatusCodeInterface::STATUS_OK);
        } else {
            if ($this->patientsRepository->AssignDocToPaz($userId, $docData['user_id'])) {
                $mail = new PHPMailer(true);
                try {
                    //Server settings
                    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host = getenv('MAIL_SMTP');                     //Set the SMTP server to send through
                    $mail->SMTPAuth = true;                                   //Enable SMTP authentication
                    $mail->Username = getenv('MAIL_USER');                     //SMTP username
                    $mail->Password = getenv('MAIL_PASS');                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom(getenv('MAIL_FROM'), 'Mental Space');
                    $mail->addAddress($data['doc_email']);

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = __('A new Patient for you !');
                    $mail_body = file_get_contents(__DIR__ . '/../../../data/mail_template/patient_assigned');
                    $search = ["{{PAZ_NOME}}", '{{PAZ_COGNOME}}', '{{DOC_NOME}}', '{{DOC_COGNOME}}'];
                    $replace = [$userData['name'], $userData['surname']. $docData['doc_name'], $docData['doc_surname']];
                    $mail_body = str_replace($search, $replace, $mail_body);
                    $mail->Body = $mail_body;
                    $mail->send();
                } catch (Exception $e) {
                    return $this->responder
                        ->withJson($response, ['status' => 'error', 'messsage' => $e->getMessage()])
                        ->withStatus(StatusCodeInterface::STATUS_OK);
                }

                return $this->responder
                    ->withJson($response, ['status' => 'success'])
                    ->withStatus(StatusCodeInterface::STATUS_OK);
            } else {
                return $this->responder
                    ->withJson($response, ['status' => 'error', 'message' => __('Error while assigning doctor')])
                    ->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
            }
        }
    }
}
