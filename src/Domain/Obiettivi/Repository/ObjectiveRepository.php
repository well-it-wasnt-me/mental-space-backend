<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Domain\Obiettivi\Repository;

use App\Factory\QueryFactory;
use App\Database\Transaction;
use Cake\Database\StatementInterface;

final class ObjectiveRepository
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

    /**
     * Genera array con tutti gli obiettivi dell'utente
     * @param $uid int User ID
     * @return array
     */
    public function listObjectives($uid): array
    {

        $query = $this->queryFactory->newSelect('obiettivi');
        $query->select([
            'ob_id',
            'obiettivo',
            'ts_obiettivo'
        ]);
        $query->orderDesc('ts_obiettivo');
        $query->where('user_id = ' . $uid);

        $rows = $query->execute()->fetchAll('assoc') ?: [];

        return $rows;
    }

    /**
     * @param $id int ID Obiettivo
     * @param $uid int ID User
     * @return StatementInterface
     */
    public function deleteObjective($id, $uid)
    {
        return $this->queryFactory->newDelete('obiettivi')
            ->where('ob_id = ' . $id . ' AND user_id = ' . $uid)
            ->execute();
    }

    /**
     * @param $data array Array [nome_campo][valore]
     * @param $uid int User ID
     * @return StatementInterface
     */
    public function addObjective($data, $uid)
    {
        $data['user_id'] = $uid;

        return $this->queryFactory->newInsert('obiettivi', $data)->execute();
    }

    public function updateObjective($ob_id, $content, $uid)
    {
        return $this->queryFactory->newUpdate(
            'obiettivi',
            [
            'obiettivo' => $content
            ]
        )->where('ob_id = ' . $ob_id . " AND user_id = " . $uid)
            ->execute();
    }
}
