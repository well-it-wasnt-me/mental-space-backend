<?php
namespace App\Domain\Diary\Repository;

use App\Domain\Doctors\Data\DoctorData;
use App\Factory\QueryFactory;
use App\Database\Transaction;
use App\Moebius\Definition;
use App\Moebius\Token;
use App\Support\Hydrator;
use Cake\Chronos\Chronos;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;

final class DiaryRepository
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

    public function getEntries($uid)
    {
        return $this->queryFactory->newSelect('diaries')
            ->select(['*'])
            ->where('user_id = ' . $uid)
            ->orderDesc('creation_date')
            ->execute()
            ->fetchAll('assoc');
    }

    public function addEntry($uid, $content)
    {
        if ($this->queryFactory->newInsert(
            'diaries',
            [
            'content' => $content['diario'],
            'user_id' => $uid
            ]
        )->execute()) {
            return true;
        }

        return false;
    }

    public function deleteEntry($user_id, $diary_id)
    {
        if ($this->queryFactory->newDelete('diaries')->where('user_id = ' . $user_id . ' AND diary_id = ' . $diary_id)->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
