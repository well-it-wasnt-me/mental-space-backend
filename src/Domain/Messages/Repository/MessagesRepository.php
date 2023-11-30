<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Domain\Messages\Repository;

use App\Factory\QueryFactory;
use App\Database\Transaction;


final class MessagesRepository
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

    public function listContacts(){
        $list = $this->queryFactory->newSelect('patients')
            ->innerJoin('users', "patients.user_id = users.user_id")
            ->innerJoin('dsm', 'patients.dsm_id = dsm.id')
            ->select(
                [
                    'CONCAT(patients.name, " ", patients.surname) AS full_name',
                    'patients.paz_id',
                    'MD5(users.email) AS gravatar',
                    'dsm.descrizione'
                ])
            ->where('patients.doc_id = ' . $_SESSION['user_id'] . " AND users.account_status = 1")
            ->execute()
            ->fetchAll('assoc') ?? [];

        return $list;
    }
}
