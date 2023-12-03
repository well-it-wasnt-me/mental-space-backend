<?php
namespace App\Domain\Consulti\Repository;

use App\Domain\Doctors\Data\DoctorData;
use App\Factory\QueryFactory;
use App\Database\Transaction;
use App\Moebius\Definition;
use App\Moebius\Token;
use App\Support\Hydrator;
use Cake\Chronos\Chronos;
use DateTime;
use Exception;
use Fig\Http\Message\StatusCodeInterface;
use PHPMailer\PHPMailer\PHPMailer;

final class ConsultRepository
{
    private QueryFactory $queryFactory;
    private Transaction $transaction;
    private Hydrator $hydrator;
    private Token $token;

    public function __construct(QueryFactory $queryFactory, Transaction $transaction, Hydrator $hydrator, Token $token)
    {
        $this->token = $token;
        $this->queryFactory = $queryFactory;
        $this->transaction = $transaction;
        $this->hydrator = $hydrator;
    }

    public function checkCode($code): bool
    {
/*
        if (!$this->token->verify_token($code)) {
            return false;
        }*/
        $data = $this->queryFactory->newSelect('consulti')
            ->select(['data_creazione', 'con_id'])
            ->where("codice = '$code'")
            ->execute()
            ->fetchAll('assoc');

        if (empty($data) || is_null($data)) {
            return false;
        }

        $data1 = new DateTime($data[0]['data_creazione']);
        $data2 = new DateTime(date("Y-m-d H:i:s"));

        $diff = $data2->diff($data1);
        $hours = $diff->h;
        $hours = $hours + ($diff->days*24);

        if ($hours >= 48) {
            $this->disattivaConsulto($data[0]['con_id']);
            return false;
        }
        
        return true;
    }

    public function checkPinCode($pin): bool
    {
        $result = $this->queryFactory->rawQuery('SELECT con_id FROM consulti WHERE pin_code = "'.$pin.'"');
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public function retrievePazID($code)
    {
        return $this->queryFactory->rawQuery("SELECT paz_id FROM consulti WHERE codice = '$code'")[0]['paz_id'];
    }

    public function retrieveUserID($code)
    {
        $paz_id = $this->queryFactory->rawQuery("SELECT paz_id FROM consulti WHERE codice = '$code'")[0]['paz_id'];
        return $this->queryFactory->rawQuery("SELECT user_id FROM patients WHERE paz_id = $paz_id")[0]['user_id'];
    }

    public function generaLink($email, int $paz_id)
    {
        $codice = $this->token->make_token(44);
        $pin_code = $this->token->make_token(16);
        $res = $this->queryFactory->newInsert(
            'consulti',
            [
                'destinatario' => $email,
                'paz_id' => $paz_id,
                'codice' => $codice,
                'pin_code' => $pin_code
            ]
        )->execute();

        if (!$res) {
            return ['status' => 'error', 'message' => __('Server Error, contatta Mental Space Support Team')];
        }

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
            $mail->addAddress($email);

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = __('Consulto Medico');
            $mail_body = file_get_contents(__DIR__ . '/../../../../data/mail_template/'.returnLocale().'/consulto_invitation');
            $search = ['{{DOC_NOME}}', '{{DOC_COGNOME}}', '{{FULL_LINK}}', '{{PIN_CODE}}'];
            $replace = [$_SESSION['fname'], $_SESSION['lname'], 'https://--INSERT KEY HERE--/public/consulto/' . $codice, $pin_code];
            $mail_body = str_replace($search, $replace, $mail_body);
            $mail->Body = $mail_body;
            $mail->send();
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => __('Errore invio E-Mail, se lo hai scritto correttamente contatta Mental Space Support Team'),
                'link' => 'https://--INSERT KEY HERE--/public/consulto/' . $codice, 'pin_code' => $pin_code ];
        }

        return ['status' => 'success', 'message' => __('Richiesta consulto inviata correttamente'),
            'link' => 'https://--INSERT KEY HERE--/public/consulto/' . $codice, 'pin_code' => $pin_code ];
    }

    public function listaConsulti($paz_id)
    {
        return $this->queryFactory->rawQuery("SELECT
    destinatario,
    CONCAT('https://--INSERT KEY HERE--/public/consulto/', codice) AS full_link,
    pin_code,
    (CASE
         WHEN stato = 1 THEN 'Attivo'
         WHEN stato = 0 THEN 'Inattivo'
         ELSE 'Sconosciuto'
        END) AS stato
FROM consulti
WHERE paz_id = $paz_id AND stato = 1");
    }

    public function disattivaConsulto($cons_id)
    {
        return $this->queryFactory->newUpdate('consulti', ['stato' => 0])
            ->where("con_id = $cons_id")
            ->execute();
    }
}
