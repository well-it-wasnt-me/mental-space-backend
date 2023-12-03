<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Domain\Tests\Repository;

use App\Factory\QueryFactory;
use App\Database\Transaction;


final class TestsRepository
{

    private QueryFactory $queryFactory;
    private Transaction $transaction;

    /**
     * The constructor.
     *
     * @param QueryFactory $queryFactory The query factory
     */
    public function __construct(QueryFactory $queryFactory, Transaction $transaction)
    {
        $this->queryFactory = $queryFactory;
        $this->transaction = $transaction;
    }

    public function addComportamentoTest(int $uid, array $testData){
        $testData['paz_id'] = $this->getPazIDByUserID($uid);

        return $this->queryFactory->newInsert('behaviours', $testData)
            ->execute();
    }

    public function addEmozioneTest(int $uid, array $testData){
        $testData['paz_id'] = $this->getPazIDByUserID($uid);

        return $this->queryFactory->newInsert('emozioni', $testData)
            ->execute();
    }

    public function addPhq9Test(int $uid, array $testData){
        $testData['paz_id'] = $this->getPazIDByUserID($uid);

        return $this->queryFactory->newInsert('phq9', $testData)
            ->execute();
    }
    public function listComportamentoTest(int $uid){
        $paz_id = $this->getPazIDByUserID($uid);
        return $this->queryFactory->newSelect('behaviours')
            ->select(['*'])
            ->orderDesc('cmp_id')
            ->where('paz_id = ' . $paz_id)
            ->execute()
            ->fetchAll('assoc');

    }

    public function listEmozioniTest(int $uid){
        $paz_id = $this->getPazIDByUserID($uid);
        return $this->queryFactory->newSelect('emozioni')
            ->select(['*'])
            ->orderDesc('em_id')
            ->where('paz_id = ' . $paz_id)
            ->execute()
            ->fetchAll('assoc');

    }

    public function listPhq9Test(int $uid){
        $paz_id = $this->getPazIDByUserID($uid);
        return $this->queryFactory->newSelect('phq9')
            ->select(['*',
                '(interesse + depresso + difficolta_sonno + stanco + poca_fame + sensi_di_colpa + difficolta_concentrazione + movimento + meglio_morte + difficolta_problemi) AS result'
                ])
            ->orderDesc('ph_id')
            ->where('paz_id = ' . $paz_id)
            ->execute()
            ->fetchAll('assoc');

    }

    private function getPazIDByUserID($uid){
        return $this->queryFactory->newSelect('patients')
            ->select(['paz_id'])
            ->where('user_id = ' . $uid )
            ->execute()
            ->fetchAll('assoc')[0]['paz_id'];
    }

    public function listaPH9($user_id){
        $paz_id = $this->getPazIDByUserID($user_id);
        return $this->queryFactory->newSelect('phq9')
            ->select(['*'])
            ->where('paz_id = ' . $paz_id)
            ->orderDesc('data_compilazione')
            ->execute()
            ->fetchAll('assoc');
    }
}
