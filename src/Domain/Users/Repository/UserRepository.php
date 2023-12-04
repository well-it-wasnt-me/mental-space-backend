<?php

namespace App\Domain\Users\Repository;

use App\Domain\Users\Data\UserDataDoc;
use App\Factory\QueryFactory;
use Cake\Chronos\Chronos;
use DomainException;

/**
 * Repository.
 */
final class UserRepository
{
    private QueryFactory $queryFactory;

    /**
     * The constructor.
     *
     * @param QueryFactory $queryFactory The query factory
     */
    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function insertPazUser($user_data)
    {

        if (empty($user_data)) {
            return 0;
        }

        $user = [
            'email' => trim(strtolower($user_data['email'])),
            'password' => hash('sha512', $user_data['password']),
            'user_type' => 1,
            'reg_date' => Chronos::now()->toDateTimeString(),
            'account_status' => 0,
            'locale' => returnLocale()
        ];

        $uid = (int)$this->queryFactory->newInsert('users', $user)
            ->execute()
            ->lastInsertId();

        $patient = [
            'name' => $user_data['f_name'],
            'surname' => $user_data['l_name'],
            'user_id' => $uid
        ];

        $paz = (int)$this->queryFactory->newInsert('patients', $patient)
            ->execute()
            ->lastInsertId();

        return $uid;
    }
    /**
     * Insert user row.
     *
     * @param UserDataDoc $user The user data
     *
     * @return int The new ID
     */
    public function insertDocUser(UserDataDoc $user): int
    {
        $row = $this->toRow($user);
        $row['reg_date'] = Chronos::now()->toDateTimeString();

        $doc_user['email'] = $row['email'];
        $doc_user['password'] = hash('sha512', $row['password']);
        $doc_user['user_type'] = 2;
        $doc_user['reg_date'] = $row['reg_date'];
        $doc_user['account_status'] = 1;
        $doc_user['locale'] = returnLocale();

        $doc_data['doc_name'] = $row['first_name'];
        $doc_data['doc_surname'] = $row['last_name'];

        $uid = (int)$this->queryFactory->newInsert('users', $doc_user)
            ->execute()
            ->lastInsertId();

        $doc_data['user_id'] = $uid;

        $this->queryFactory->newInsert('doctors', $doc_data)->execute();

        return $uid;
    }

    /**
     * Get user by id.
     *
     * @param int $userId The user id
     *
     * @return Aray The user
     *@throws DomainException
     *
     */
    public function getUserById(int $userId): array
    {
        $query = $this->queryFactory->newSelect('patients');
        $query->innerJoin('users', 'patients.user_id = users.user_id');
        $query->select(
            [
                'users.user_id',
                'patients.name',
                'patients.surname',
                'users.email',
            ]
        );

        $query->andWhere(['users.user_id' => $userId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            $row = [];
        }

        return $row;
    }

    public function getDocByEmail(string $email): array
    {
        $query = $this->queryFactory->newSelect('doctors');
        $query->innerJoin('users', 'doctors.user_id = users.user_id');
        $query->select(
            [
                'users.user_id',
                'doctors.doc_name',
                'doctors.doc_surname',
            ]
        );

        $query->andWhere(['users.email' => $email]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            $row = [];
        }

        return $row;
    }

    /**
     * Update user row.
     *
     * @param UserDataDoc $user The user
     *
     * @return array
     */
    public function updateUser($userID, $user): array
    {
        //$row = $this->toRow($user);
        $row = [
            'name' => $user['f_name'],
            'surname' => $user['l_name'],
            'cf' => $user['cf'],
            'dob' => $user['dob'],
            'em_nome' => $user['em_nome'],
            'em_telefono' => $user['em_telefono'],
            'telefono' => $user['telefono'],
            'weight' => $user['weight'],
            'height' => $user['height'],
        ];
        if (!$this->queryFactory->newUpdate('patients', $row)
            ->andWhere(['user_id = ' . $userID])
            ->execute()) {
            return ['status'=>'error', 'message' => __('Something went wrong, try again later')];
        }

        return ['status'=>'success', 'message' => __('Updated')];
    }

    public function updateUserPassword(UserDataDoc $user): array
    {
        $row = $this->toRow($user);

        // Unsetta tutto tranne pwd
        // lo so...è na strunzat

        unset($row['first_name']);
        unset($row['last_name']);
        unset($row['email']);
        unset($row['updated_at']);
        unset($row['locale']);
        unset($row['user_type']);
        
        $row['password'] = hash('sha512', $row['password']);
        $row['updated_at'] = Chronos::now()->toDateTimeString();

        if (!$this->queryFactory->newUpdate('users', $row)
            ->andWhere(['id' => $user->id])
            ->execute()) {
            return ['status'=>'error', 'message' => __('Something went wrong, try again later')];
        }

        return ['status'=>'success', 'message' => __('Updated Successfull')];
    }

    /**
     * Check user id.
     *
     * @param int $userId The user id
     *
     * @return bool True if exists
     */
    public function existsUserId(int $userId): bool
    {
        $query = $this->queryFactory->newSelect('users');
        $query->select('id')->andWhere(['id' => $userId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    /**
     * Delete user row.
     *
     * @param int $userId The user id
     *
     * @return void
     */
    public function deleteUserById(int $userId): void
    {
        $this->queryFactory->newDelete('users')
            ->andWhere(['user_id' => $userId])
            ->execute();
        $this->queryFactory->newDelete('patients')
            ->andWhere(['user_id' => $userId])
            ->execute();
    }

    public function docDeleteUserById(int $userId): void
    {
        $this->queryFactory->newDelete('users')
            ->andWhere(['user_id' => $userId])
            ->execute();
    }

    /**
     * Convert to array.
     *
     * @param UserDataDoc $user The user data
     *
     * @return array The array
     */
    private function toRow(UserDataDoc $user): array
    {
        return [
            'first_name' => $user->f_name,
            'last_name' => $user->l_name,
            'email' => $user->email,
            'password' => $user->passwd,
            'locale' => $user->locale,
            'user_type' => (int)$user->user_role,
        ];
    }

    public function addTracking($user_id, $coords, $addr)
    {
        if (empty($addr)) {
            $addr = $this->getaddress($coords);
        }
        $query = $this->queryFactory->newInsert('trackings', ['user_id' => $user_id, 'coords' => $coords, 'addr' => $addr]);

        return (bool)$query->execute();
    }

    function getPazIDByUserID($user_id)
    {
        return $this->queryFactory->newSelect('patients')
            ->select(['paz_id'])
            ->where("user_id = $user_id")
            ->execute()
            ->fetchAll('assoc')[0];
    }

    public function retrieveCalendar($user_id)
    {
        try {
            $query = $this->queryFactory->newSelect('calendar');
            $query->select(
                [
                    '*',
                ]
            );

            $query->where('paz_id = ' . $this->getPazIDByUserID($user_id)['paz_id']);

            $row = $query->execute()->fetchAll('assoc');
            return $row;
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }


    public function updateUserAddr($userID, $user): array
    {
        //$row = $this->toRow($user);
        $row = [
            'address' => $user['indirizzo'],
        ];
        if (!$this->queryFactory->newUpdate('patients', $row)
            ->andWhere(['user_id = ' . $userID])
            ->execute()) {
            return ['status'=>'error', 'message' => __('Something went wrong, try again later')];
        }

        return ['status'=>'success', 'message' => __('Updated')];
    }

    function getaddress($coord)
    {
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($coord).'&sensor=false&key=--INSERT KEY HERE--';
        $json = @file_get_contents($url);
        $data=json_decode($json);
        $status = $data->status;
        if ($status=="OK") {
            return $data->results[0]->formatted_address;
        } else {
            return $data->error_message;
        }
    }

    public function trackUserList($uid)
    {
        return $this->queryFactory->rawQuery("SELECT user_id,
       addr,
       FROM_DAYS(TO_DAYS(effective_data) -MOD(TO_DAYS(effective_data) -2, 7)) AS week_beginning,
       TIMESTAMPDIFF(MINUTE,MIN(effective_data), MAX(effective_data)) AS total_time,
       COUNT(*) AS tracks
FROM trackings
WHERE user_id = $uid
GROUP BY FROM_DAYS(TO_DAYS(effective_data) -MOD(TO_DAYS(effective_data) -2, 7)), user_id, addr
ORDER BY FROM_DAYS(TO_DAYS(effective_data) -MOD(TO_DAYS(effective_data) -2, 7))");
    }

    public function historyAccess($uid)
    {
        return $this->queryFactory->newSelect('access_log')
            ->select(['ip', 'browser', 'os','location', 'ts'])
            ->where('user_id = ' . $uid)
            ->orderDesc('ts')
            ->execute()
            ->fetchAll('assoc');
    }

    public function pwdUpdate($data, $uid)
    {
        $data['password'] = hash('sha512', $data['password']);

        if (!$this->checkPwd($data['old_password'], $uid)) {
            return ['status'=>'error', 'message' => __('Actual password is not correct, try again')];
        }


        if (!$this->queryFactory->newUpdate('users', ['password' => $data['password']])
            ->andWhere(['user_id' => $uid])
            ->execute()) {
            return ['status'=>'error', 'message' => __('Something went wrong')];
        }

        return ['status'=>'success', 'message' => __('Password Updated')];
    }

    public function checkPwd($pwd, $uid)
    {
        $pwd_db = $this->queryFactory->newSelect('users')
            ->select(['password'])
            ->where('user_id = ' . $uid)
            ->execute()
            ->fetchAll('assoc')[0]['password'];

        if ($pwd_db === hash('sha512', $pwd)) {
            return true;
        }

        return false;
    }
}
