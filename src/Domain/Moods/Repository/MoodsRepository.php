<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Domain\Moods\Repository;

use App\Factory\QueryFactory;
use App\Database\Transaction;
use App\Moebius\Definition;
use App\Moebius\Krypton;
use App\Moebius\Token;
use App\Support\Hydrator;
use Cake\Chronos\Chronos;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;

final class MoodsRepository
{

    private QueryFactory $queryFactory;
    private Transaction $transaction;
    private Hydrator $hydrator;

    /**
     * The constructor.
     *
     * @param QueryFactory $queryFactory The query factory
     */
    public function __construct(QueryFactory $queryFactory, Transaction $transaction, Hydrator $hydrator)
    {
        $this->queryFactory = $queryFactory;
        $this->transaction = $transaction;
        $this->hydrator = $hydrator;
    }

    /**
     * @param int $user_id
     * @param int $mood
     * @return int
     */
    function insertMood($user_id, $mood, $w_sign): array
    {
        $this->transaction->begin();

        $my_mood = [
          'usr_id' => $user_id,
          'mood_id' => $mood,
          'warning_sign' => $w_sign
        ];

        try {
            $mood_id = $this->queryFactory->newInsert('mood_trackings', $my_mood)->execute()->lastInsertId();
        } catch (Exception $e) {
            $this->transaction->rollback();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }

        $this->transaction->commit();

        return ['status' => 'success'];
    }

    function ultimi10mood($uid){
        $data = $this->queryFactory->newSelect('mood_trackings')
        ->innerJoin('moods', "mood_trackings.mood_id = moods.mood_id")
        ->select(['moods.value', 'mood_trackings.effective_datetime', 'moods.slogan', 'moods.image','mood_trackings.trk_id', 'mood_trackings.warning_sign'])
        ->where('mood_trackings.usr_id = ' . $uid)
        ->orderDesc('mood_trackings.trk_id')->execute()->fetchAll('assoc');

        return [$data];
    }

    function ultimi10moodGraph($uid){
        $data = $this->queryFactory->newSelect('mood_trackings')
            ->innerJoin('moods', "mood_trackings.mood_id = moods.mood_id")
            ->select(['COUNT(*) AS y', 'moods.value as x'])
            ->group('mood_trackings.mood_id')
            ->where('mood_trackings.usr_id = ' . $uid . ' AND DATE(effective_datetime) >= ( NOW() - INTERVAL 7 DAY )')->execute()->fetchAll('assoc');

        return [$data];
    }

    function deleteMood($mood_id, $user_id){
        $data = $this->queryFactory->newDelete('mood_trackings')
            ->where('usr_id = ' . $user_id . ' AND trk_id = ' . $mood_id)
            ->execute();
        if( $data->errorInfo()[0] === "00000" ) {
            return true;
        }

        return false;
    }

    function periodoMood($uid, $dataA, $dateB){
        $data = $this->queryFactory->newSelect('mood_trackings')
            ->innerJoin('moods', "mood_trackings.mood_id = moods.mood_id")
            ->select(['moods.value', 'mood_trackings.effective_datetime', 'moods.slogan', 'moods.image','mood_trackings.trk_id', 'mood_trackings.warning_sign'])
            ->where('mood_trackings.usr_id = ' . $uid . ' AND DATE(mood_trackings.effective_datetime) >= "' . $dataA.'" AND DATE(mood_trackings.effective_datetime) <= "' . $dateB.'"')
            ->orderDesc('mood_trackings.trk_id')->execute()->fetchAll('assoc');

        return $data;
    }
}
