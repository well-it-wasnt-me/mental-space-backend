<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Domain\Cities\Repository;

use App\Factory\QueryFactory;
use App\Database\Transaction;


final class CitiesRepository
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

    public function listCities(): array
    {
        $query = $this->queryFactory->newSelect('cities');
        $query->select([
            '*',
        ]);

        $rows = $query->execute()->fetchAll('assoc') ?: [];

        return $rows;
    }
}
