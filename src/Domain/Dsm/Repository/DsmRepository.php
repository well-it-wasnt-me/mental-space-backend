<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Domain\Dsm\Repository;

use App\Factory\QueryFactory;
use App\Database\Transaction;

final class DsmRepository
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

    public function listDsm(): array
    {
        $query = $this->queryFactory->newSelect('dsm');
        $query->select([
            '*',
        ]);

        $rows = $query->execute()->fetchAll('assoc') ?: [];

        return $rows;
    }

    public function selectListDsm($term):array
    {
        $dsm = $this->queryFactory->newSelect('dsm')
            ->select(['id', 'descrizione AS text'])
            ->where("descrizione LIKE '%$term%'")
            ->execute()
            ->fetchAll('assoc');
        return ['results' => $dsm];
    }
}
