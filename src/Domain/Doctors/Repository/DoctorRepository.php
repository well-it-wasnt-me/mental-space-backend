<?php
namespace App\Domain\Doctors\Repository;

use App\Domain\Doctors\Data\DoctorData;
use App\Factory\QueryFactory;
use App\Database\Transaction;
use App\Moebius\Definition;
use App\Moebius\Token;
use App\Support\Hydrator;
use Cake\Chronos\Chronos;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;

final class DoctorRepository
{
    private QueryFactory $queryFactory;
    private Transaction $transaction;
    private Hydrator $hydrator;

    public function __construct(QueryFactory $queryFactory, Transaction $transaction, Hydrator $hydrator)
    {
        $this->queryFactory = $queryFactory;
        $this->transaction = $transaction;
        $this->hydrator = $hydrator;
    }

    public function doctorDetail(): array
    {
        $query = $this->queryFactory->newSelect('doctors');
        $query->innerJoin('users', 'doctors.user_id = users.user_id');
        $query->select([
            'doctors.*',
            'users.*',
        ]);
        $query->where('doctors.user_id = ' . $_SESSION['user_id']);

        $rows = $query->execute()->fetchAll('assoc') ?: [];

        return $rows;
    }

    public function AppdoctorDetail($user_id): array
    {
        $doc_id = $this->queryFactory->newSelect('patients')
            ->select(['doc_id'])
            ->where('user_id = ' . $user_id)
            ->execute()
            ->fetchAll('assoc');

        $query = $this->queryFactory->newSelect('doctors');
        $query->innerJoin('users', 'doctors.user_id = users.user_id');
        $query->innerJoin('patients', 'doctors.user_id = users.user_id');
        $query->select([
            'doctors.*',
            'users.email',
        ]);
        $query->where('doctors.user_id = ' . $doc_id[0]['doc_id']);

        $rows = $query->execute()->fetchAll('assoc') ?: [];

        return $rows;
    }

    public function updateDoctor(DoctorData $data){


        $data = [
            'doc_name' => $data->doc_name,
            'doc_surname' => $data->doc_surname,
            'doc_rag_soc' => $data->doc_rag_soc,
            'doc_tel' => $data->doc_tel,
            'doc_photo' => $data->doc_photo,
            'doc_hourlyrate' => $data->doc_hourlyrate,
            'doc_address' => $data->doc_address,
            'doc_paypal' => $data->doc_paypal,
            'doc_piva' => $data->doc_piva
        ];
        $query = $this->queryFactory->newUpdate('doctors', $data)
            ->execute();

        if($query){
            return ['status' => 'success'];
        } else {
            return ['status' => 'error'];
        }
    }

    public function unsetPaz($uid){
        $this->queryFactory->newUpdate('patients', ['doc_id' => 0])
            ->where('patients.user_id = ' . $uid)
            ->execute();

        return true;
    }
}