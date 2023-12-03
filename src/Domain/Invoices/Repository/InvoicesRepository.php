<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Domain\Invoices\Repository;

use App\Factory\QueryFactory;
use App\Database\Transaction;

final class InvoicesRepository
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

    public function listInvoices()
    {
        $invoices = $this->queryFactory->newSelect('invoices')
            ->select(['*'])
            ->where('doc_id = ' . $_SESSION['user_id'])
            ->execute()
            ->fetchAll('assoc') ?? [];

        return $invoices;
    }
}
