<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Domain\Calendar\Repository;

use App\Factory\QueryFactory;
use App\Database\Transaction;


final class CalendarRepository
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

    public function listEvents(): array
    {
        $query = $this->queryFactory->newSelect('calendar');
        $query->select([
            '*',
        ]);

        $query->where('doc_id = ' . $_SESSION['user_id']);

        $query->orderAsc('id');

        $rows = $query->execute()->fetchAll('assoc') ?: [];

        return $rows;
    }

    public function addEvent(array $event){
        $event['doc_id'] = $_SESSION['user_id'];
        return $this->queryFactory->newInsert('calendar', $event)
            ->execute();
    }
}
