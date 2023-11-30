<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Domain\Pharm\Repository;

use App\Factory\QueryFactory;
use App\Database\Transaction;


final class PharmRepository
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

    public function listDrugs($for_select): array
    {

        if($for_select){
            $query = $this->queryFactory->newSelect('farmaci');
            $query->select([
                'farmaci.id AS id',
                'farmaci.descrizione_gruppo AS text',
            ]);

            $rows = $query->execute()->fetchAll('assoc') ?: [];

            return $rows;
        }

        $query = $this->queryFactory->newSelect('farmaci');
        $query->select([
            '*',
        ]);

        $rows = $query->execute()->fetchAll('assoc') ?: [];

        return $rows;
    }

    public function seaerchDrug($name): array
    {
        $query = $this->queryFactory->newSelect('farmaci');
        $query->select([
            '*',
        ]);
        $query->where("denom LIKE '%$name%' OR principio_attivo LIKE '%$name%'");

        $rows = $query->execute()->fetchAll('assoc') ?: [];

        return $rows;
    }

    public function webSearchDrug($name): array {
            $query = $this->queryFactory->newSelect('farmaci');
            $query->select([
                'id',
                'denom AS text'
            ]);
            $query->where("denom LIKE '%$name%' OR principio_attivo LIKE '%$name%'");

            $rows = $query->execute()->fetchAll('assoc') ?: [];

            return ['results' => $rows];

    }

    public function deleteDrug($id, $uid){
        $pid = $this->queryFactory->newSelect('patients')->select(['paz_id'])
            ->where('user_id = ' . $uid)
            ->execute()
            ->fetchAll('assoc');

        return $this->queryFactory->newDelete('assegnazione_farmaci')
            ->where('id = ' . $id . ' AND paz_id = ' . $pid[0]['paz_id'])
            ->execute();
    }

    public function addDrug($data, $uid){
        $pid = $this->queryFactory->newSelect('patients')->select(['paz_id'])
            ->where('user_id = ' . $uid)
            ->execute()
            ->fetchAll('assoc');

        $data['paz_id'] = $pid[0]['paz_id'];

        return $this->queryFactory->newInsert('assegnazione_farmaci', $data)->execute();
    }

    public function userDrug($uid){
        $paz_id = $this->queryFactory->newSelect('patients')
            ->select(['paz_id'])
            ->where('user_id = ' . $uid)
        ->execute()->fetchAll('assoc');

        return $this->queryFactory->newSelect('assegnazione_farmaci')
            ->innerJoin('farmaci', 'assegnazione_farmaci.farm_id = farmaci.id')
            ->select(['farmaci.principio_attivo', 'farmaci.denom', 'farmaci.prezzo'])
            ->where('assegnazione_farmaci.paz_id = ' . $paz_id[0]['paz_id'])
            ->execute()->fetchAll('assoc');
    }
}
