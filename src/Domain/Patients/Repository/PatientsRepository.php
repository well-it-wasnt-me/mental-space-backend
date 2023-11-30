<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Domain\Patients\Repository;

use App\Domain\Patients\Data\PatientData;
use App\Factory\QueryFactory;
use App\Database\Transaction;
use App\Moebius\Definition;
use App\Moebius\Krypton;
use App\Moebius\Token;
use App\Support\Hydrator;
use Cake\Chronos\Chronos;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;

final class PatientsRepository
{

    private QueryFactory $queryFactory;
    private Transaction $transaction;
    private Hydrator $hydrator;

    /**
     * The constructor.
     *
     * @param QueryFactory $queryFactory The query factory
     */
    public function __construct(QueryFactory $queryFactory, Transaction $transaction, Hydrator $hydrator)
    {
        $this->queryFactory = $queryFactory;
        $this->transaction = $transaction;
        $this->hydrator = $hydrator;
    }

    /**
     * @param PatientData $patientData
     * @return int
     */
    function insertPatient(PatientData $patientData, $rawData): array
    {

        $krypton = new Krypton();

        $this->transaction->begin();

        $patient = [
            'name' => $patientData->name,
            'surname' => $patientData->surname,
            'dob' => $patientData->dob,
            'address' => $patientData->address,
            'height' => $patientData->height,
            'weight' => $patientData->weight,
            'notes' => $patientData->relazione,
            //'dsm_id' => $patientData->dsm_id,
            'doc_id' => $_SESSION['user_id'],
            'telefono' => $patientData->telefono,
            'em_nome' => $patientData->em_nome,
            'em_telefono' => $patientData->em_telefono,
        ];


        try {
            $paz_id = $this->queryFactory->newInsert('patients', $patient)->execute()->lastInsertId();
        } catch (Exception $e) {
            $this->transaction->rollback();
            echo $e->getMessage();
        }
        $arr = (array)$rawData['curr_pharms'];
        foreach ($arr as $val) {
            $this->queryFactory->newInsert('assegnazione_farmaci', ['paz_id' => $paz_id, 'farm_id' => $val])->execute();
        }

        $arr = (array)$rawData['dsm_id'];
        foreach ($arr as $val) {
            $this->queryFactory->newInsert('assegnazione_diagnosi', ['paz_id' => $paz_id, 'dsm_id' => $val])->execute();
        }

        if ($patientData->invito === 'checked') {
            $token = new Token();
            $rnd_pass = $token->make_token(8);

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
                $mail->addAddress($patientData->email, $patientData->name . " " . $patientData->surname);

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = __('Invito a partecipare a Mental Space');
                $mail_body = file_get_contents(__DIR__ . '/../../../../data/mail_template/'.returnLocale().'/patient_invitation');
                $mail_body = str_replace("{{PAZ_NOME}}", $patientData->name, $mail_body);
                $mail_body = str_replace("{{PAZ_COGNOME}}", $patientData->surname, $mail_body);
                $mail_body = str_replace("{{DOC_NOME}}", $_SESSION['fname'], $mail_body);
                $mail_body = str_replace("{{DOC_COGNOME}}", $_SESSION['lname'], $mail_body);
                $mail->Body = $mail_body;
                $mail->send();
            } catch (\Exception $e) {
                $this->transaction->rollback();
                return ['status' => 'error', 'message' => 'Died sending mail ' . $e->getMessage()];
            }


            $puid = $this->queryFactory->newInsert('users', ['email' => $patientData->email, 'password' => hash('sha512', $rnd_pass), 'user_type' => 1])->execute()->lastInsertId();
            $this->queryFactory->newUpdate('patients', ['user_id' => $puid])->where('paz_id = ' . $paz_id);
        }

        $this->transaction->commit();
        return ['status' => 'success'];
    }
    public function listPatients(): array
    {
        $query = $this->queryFactory->newSelect('patients');
        $query->leftJoin('users', 'patients.user_id = users.user_id');
        $query->select([
           'patients.paz_id',
           'patients.name',
           'patients.surname',
           'patients.dob',
           'patients.photo',
           'patients.data_inizio_cure',
           'users.email',
           'users.account_status',
           '(SELECT GROUP_CONCAT(dsm.descrizione) FROM dsm INNER JOIN assegnazione_diagnosi ON assegnazione_diagnosi.dsm_id = dsm.id AND assegnazione_diagnosi.paz_id = patients.paz_id) AS descrizione',
        ]);

        $query->where('patients.doc_id = ' . $_SESSION['user_id']);

        $rows = $query->execute()->fetchAll('assoc') ?: [];

        return $rows;
    }

    /**
     * Return all the smartbox information
     * @param string $id Patients ID
     * @return array
     */
    public function patientDetail($id): array
    {
        $query = $this->queryFactory->newSelect('patients');
        $query->leftJoin('users', 'patients.user_id = users.user_id');
        $query->leftJoin('dsm', 'patients.dsm_id = dsm.id');
        $query->select([
            'patients.*',
            'users.*',
            '"" AS icd_ten',
            '(SELECT GROUP_CONCAT(dsm.id, " * ", dsm.descrizione SEPARATOR ";") FROM dsm INNER JOIN assegnazione_diagnosi ON assegnazione_diagnosi.dsm_id = dsm.id AND assegnazione_diagnosi.paz_id = ' . $id .') AS descrizione',
            '(SELECT COUNT(*) FROM diaries WHERE user_id = users.user_id) AS tot_post',
            '(SELECT passi FROM passi WHERE user_id = users.user_id AND data_inserimento = DATE(NOW()) ORDER BY pass_id DESC LIMIT 1) AS tot_passi',
        ]);
        $query->where('patients.paz_id = ' . $id . ' AND patients.doc_id = ' . $_SESSION['user_id']);

        $rows = $query->execute()->fetchAll('assoc') ?: [];

        return $rows;
    }

    public function listPharmPat($id_paz, $consulto = false): array
    {

        $doc_id = $this->queryFactory->newSelect('patients')->select(['doc_id'])->where('paz_id = ' . $id_paz)->execute()->fetchAll();

        if( !$consulto){
            if ($doc_id[0][0] != $_SESSION['user_id']) {
                return [];
            }

        }

        $query = $this->queryFactory->newSelect('assegnazione_farmaci');
        $query->innerJoin('farmaci', 'assegnazione_farmaci.farm_id = farmaci.id');
        $query->select([
            'farmaci.*',
            'assegnazione_farmaci.id',
        ]);
        $query->where('assegnazione_farmaci.paz_id = ' . $id_paz);

        $rows = $query->execute()->fetchAll('assoc') ?: [];

        return $rows;
    }


    /**
     * Update smartbox settings data
     * @param array $data Form Data
     * @return bool
     */
    public function updatePatient($data, $rawData): bool
    {
        $sbs = [
              'surname' => $data['modalEditUserLastName'],
              'name' => $data['modalEditUserFirstName'],
              'cf' => $data['modalEditUserName'],
              'telefono' => $data['modalEditUserTel'],
              'em_nome' => $data['modalEditEmNome'],
              'em_telefono' => $data['modalEditEmPhone'],
              'address' => $data['modalEditUserIndirizzo'],
        ];

        $query = $this->queryFactory->newUpdate('patients', $sbs);
        $query->where('paz_id = ' . $data['paz_id']);

        $query2 = $this->queryFactory->newDelete('assegnazione_diagnosi')
            ->where('paz_id = ' . $data['paz_id']);

        try {
            $query->execute();
            $query2->execute();
            $arr = (array)$rawData['modalEditUserDsm'];
            foreach ($arr as $val) {
                $this->queryFactory->newInsert('assegnazione_diagnosi', ['paz_id' => $data['paz_id'], 'dsm_id' => $val])->execute();
            }


            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }




    public function AssignDocToPaz($paz_id, $doc_id)
    {
        $query = $this->queryFactory->newUpdate('patients', ['doc_id' => $doc_id])
            ->where('patients.user_id = ' . $paz_id)
            ->execute();

        if (!$query) {
            return false;
        }

        return true;
    }

    public function listPharmPatMobile($id_paz): array
    {

        $query = $this->queryFactory->newSelect('assegnazione_farmaci');
        $query->innerJoin('farmaci', 'assegnazione_farmaci.farm_id = farmaci.id');
        $query->select([
            'farmaci.*',
            'assegnazione_farmaci.id',
            'assegnazione_farmaci.farm_id',
            'assegnazione_farmaci.paz_id',
            'assegnazione_farmaci.data_assegnazione',
            'assegnazione_farmaci.oraPrimaDoseDoppia',
            'assegnazione_farmaci.oraPrimaDoseSingola',
            'assegnazione_farmaci.oraSecondaDoseDoppia',
            'assegnazione_farmaci.scheduled',
        ]);
        $query->where('assegnazione_farmaci.paz_id = ' . $this->getPazId($id_paz)['paz_id']);

        $rows = $query->execute()->fetchAll('assoc') ?: [];

        return $rows;
    }

    function getPazId($uid)
    {
        $q = $this->queryFactory->newSelect('patients')
            ->select(['paz_id'])
            ->where('user_id = ' . $uid)
            ->execute()->fetchAll('assoc');

        return $q[0];
    }

    public function last10moods($uid)
    {
        $data = $this->queryFactory->newSelect('mood_trackings')
            ->innerJoin('moods', "mood_trackings.mood_id = moods.mood_id")
            ->select(['moods.value', 'mood_trackings.effective_datetime', 'moods.slogan', 'moods.image','mood_trackings.trk_id', 'mood_trackings.warning_sign'])
            ->where('mood_trackings.usr_id = ' . $uid)
            ->orderDesc('mood_trackings.trk_id')->limit(10)
            ->execute()->fetchAll('assoc');

        return $data;
    }

    public function listDiary($uid)
    {
        return $this->queryFactory->newSelect('diaries')
            ->select(['content', 'diary_id', 'creation_date'])
            ->orderDesc("creation_date")
            ->where('user_id = ' . $uid)
            ->execute()
            ->fetchAll('assoc');
    }

    public function listAllmoods($uid)
    {
        $data = $this->queryFactory->newSelect('mood_trackings')
            ->innerJoin('moods', "mood_trackings.mood_id = moods.mood_id")
            ->select(['COUNT(*) AS y', 'moods.value as x'])
            ->group('mood_trackings.mood_id')
            ->where('mood_trackings.usr_id = ' . $uid)->execute()->fetchAll('assoc');

        return [$data];
    }

    public function searchPat($full_name)
    {
        if (!isset($_SESSION['user_id'])) {
            return  [];
        }
        return $this->queryFactory->newSelect('patients')
            ->select(['paz_id', 'name', 'surname', 'dob'])
            ->where('doc_id = ' . $_SESSION['user_id'] . ' AND (name LIKE "%' . $full_name . '%" OR surname LIKE "%'.$full_name.'%")')
            ->execute()
            ->fetchAll('assoc');
    }

    function addPill(int $pill_id, int $paz_id)
    {
        if ($this->queryFactory->newInsert(
            'assegnazione_farmaci',
            ['paz_id' => $paz_id, 'farm_id' => $pill_id]
        )->execute()) {
            return ['status' => 'success', 'message' => 'Farmaco inserito con successo'];
        }

        return ['status' => 'error', 'message' => 'Qualcosa è andato storto, riprova o contattaci'];
    }

    function delPill(int $paz_id, int $ass_id)
    {
        if ($this->queryFactory->newDelete('assegnazione_farmaci')
            ->where('paz_id = ' . $paz_id . ' AND id = ' . $ass_id)->execute()) {
            return ['status' => 'success', 'message' => 'Farmaco inserito con successo'];
        }

        return ['status' => 'error', 'message' => 'Qualcosa è andato storto, riprova o contattaci'];
    }

    function deletePatient(int $paz_id){
        if($this->queryFactory->newUpdate('patients', ['doc_id' => null])
        ->where('paz_id = ' . $paz_id . ' AND doc_id = ' . $_SESSION['user_id'])
        ->execute()){
            return ['status' => 'success', 'message' => 'Paziente eliminato con successo'];
        }
        return ['status' => 'error', 'message' => 'Qualcosa è andato storto, riprova o contattaci'];
    }

    function listAnnotation($paz_id, $consulto = false){
        $addWhere = "";
        if( !$consulto){
            $addWhere = " AND doc_id = " . $_SESSION['user_id'];
        }
        return $this->queryFactory->newSelect('annotazioni')
            ->select(['annotazione', 'ann_id', 'creation_date'])
            ->orderDesc("creation_date")
            ->where('paz_id = ' . $paz_id . " $addWhere")
            ->execute()
            ->fetchAll('assoc');
    }

    function addAnnotation(array $data){
        $data['doc_id'] = $_SESSION['user_id'];
        if( $this->queryFactory->newInsert('annotazioni', $data)
            ->execute() ){
            return ['status' => 'success'];
        }

        return ['status' => 'error'];
    }

    function deleteAnnotation(int $ann_id){
        return $this->queryFactory->newDelete('annotazioni')
            ->where('ann_id = '. $ann_id . " AND doc_id = ".$_SESSION['user_id'])
            ->execute();
    }

    function caricaRelazione(int $paz_id){
        return $this->queryFactory->newSelect('patients')
            ->select(['notes'])
            ->where('paz_id = ' . $paz_id . ' AND doc_id = ' . $_SESSION['user_id'])
            ->execute()
            ->fetchAll('assoc');
    }

    function salvaRelazione(int $paz_id, string $content){
        return $this->queryFactory->newUpdate('patients',
        ['notes' => $content]
        )->where('paz_id = ' . $paz_id . ' AND doc_id = ' . $_SESSION['user_id'])
            ->execute();
    }

    public function selectSearchPat($full_name)
    {
        if (!isset($_SESSION['user_id'])) {
            return  [];
        }

        $full_name = addslashes($full_name);
        return $this->queryFactory->rawQuery('SELECT paz_id AS id,CONCAT(name, \' \', surname, \' - \', dob) AS text FROM patients WHERE doc_id = ' . $_SESSION['user_id']);
    }

    public function listDepressione(int $paz_id){
        $data = $this->queryFactory->rawQuery("SELECT
    (interesse + depresso + difficolta_sonno + stanco + poca_fame + sensi_di_colpa + difficolta_concentrazione + movimento + meglio_morte + difficolta_problemi ) AS y,
    data_compilazione AS x
FROM phq9
WHERE paz_id = $paz_id ORDER BY data_compilazione ASC");
        return [$data];
    }

    public function searchPatient($term){
        if (!isset($_SESSION['user_id'])) {
            return  [];
        }
        return $this->queryFactory->rawQuery('
        SELECT paz_id AS id,
        CONCAT(name, " ", surname, " - ", dob) AS text
        FROM patients
        WHERE doc_id = ' . $_SESSION['user_id'] . ' AND (name LIKE "%' . $term . '%" OR surname LIKE "%'.$term.'%")');
    }

    public function consultoPatientDetail($id): array
    {
        $query = $this->queryFactory->newSelect('patients');
        $query->leftJoin('users', 'patients.user_id = users.user_id');
        $query->leftJoin('dsm', 'patients.dsm_id = dsm.id');
        $query->select([
            'patients.*',
            'users.*',
            '"" AS icd_ten',
            '(SELECT GROUP_CONCAT(dsm.id, " * ", dsm.descrizione SEPARATOR ";") FROM dsm INNER JOIN assegnazione_diagnosi ON assegnazione_diagnosi.dsm_id = dsm.id AND assegnazione_diagnosi.paz_id = ' . $id .') AS descrizione',
            '(SELECT COUNT(*) FROM diaries WHERE user_id = users.user_id) AS tot_post',
            '(SELECT passi FROM passi WHERE user_id = users.user_id AND data_inserimento = DATE(NOW()) ORDER BY pass_id DESC LIMIT 1) AS tot_passi',
        ]);
        $query->where('patients.paz_id = ' . $id );

        $rows = $query->execute()->fetchAll('assoc') ?: [];

        return $rows;
    }
}
