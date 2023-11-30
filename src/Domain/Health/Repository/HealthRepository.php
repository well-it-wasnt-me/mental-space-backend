<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Domain\Health\Repository;

use App\Factory\QueryFactory;
use App\Database\Transaction;


final class HealthRepository
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

    public function aggiungiPassi(int $uid, int $passi){
        return $this->queryFactory->newInsert('passi',['user_id' => $uid, 'passi' => $passi, 'data_inserimento' => date('Y-m-d')])
            ->execute();
    }
}
