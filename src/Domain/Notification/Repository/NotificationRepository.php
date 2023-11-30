<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Domain\Notification\Repository;

use App\Factory\QueryFactory;
use App\Database\Transaction;
use App\Moebius\Definition;
use App\Moebius\Krypton;
use App\Moebius\Token;
use App\Support\Hydrator;
use Cake\Chronos\Chronos;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;

final class NotificationRepository
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

    public function registerDevice($uid, $token){
        return $this->queryFactory->newInsert('notification_devices', [
            'uid' => $uid,
            'token' => $token
        ])->execute();
    }
}
