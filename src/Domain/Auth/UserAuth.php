<?php

namespace App\Domain\Auth;

use App\Factory\QueryFactory;
use App\Moebius\Definition;
use PDO;

class UserAuth
{
    /**
     * @var PDO
     */
    private PDO $connection;
    private QueryFactory $query;

    /**
     * UserAuth constructor.
     * @param PDO $pdo Database Connection
     */
    function __construct(PDO $pdo, QueryFactory $query)
    {
        $this->connection = $pdo;
        $this->query = $query;
    }

    /**
     * @param string $username Email
     * @param string $password Password
     * @return array
     */
    public function authenticate(string $username, string $password, string $role): array
    {

        $password = hash('sha512', $password);

        $q = "SELECT users.*, doctors.* FROM mentalspace.users
         LEFT JOIN mentalspace.doctors
         ON doctors.user_id = users.user_id
         WHERE users.email = :email 
           AND users.password = :password 
           AND users.account_status = 1 
           AND users.user_type = 2";
        $st = $this->connection->prepare($q);
        $st->bindParam(":email", $username);
        $st->bindParam(":password", $password);

        $st->execute();

        $data = $st->fetchAll();

        if (empty($data)) {
            return [];
        }

        return [
            'f_name'        => $data[0]['doc_name'],
            'l_name'        => $data[0]['doc_surname'],
            'photo'         => $data[0]['doc_photo'],
            'user_id'       => $data[0]['user_id'],
            'role'          => $data[0]['user_type'],
            'locale'        => $data[0]['locale'],
            'email'         => $data[0]['email'],
            'reg_date'      => $data[0]['reg_date'],
            'account_status'=> $data[0]['account_status'],
        ];
    }

    public function authenticate_paz(string $username, string $password, string $role): array
    {

        $username = trim(strtolower($username));
        $password = trim($password);
        $password = hash('sha512', $password);

        $q = "SELECT users.*, patients.* FROM mentalspace.users
         LEFT JOIN mentalspace.patients
         ON patients.user_id = users.user_id
         WHERE users.email = :email 
           AND users.password = :password 
           AND users.user_type = 1";
        $st = $this->connection->prepare($q);
        $st->bindParam(":email", $username);
        $st->bindParam(":password", $password);

        $st->execute();

        $data = $st->fetchAll();

        if (empty($data)) {
            return [];
        }

        return [
            'f_name'        => $data[0]['name'],
            'l_name'        => $data[0]['surname'],
            'photo'         => $data[0]['photo'],
            'user_id'       => $data[0]['user_id'],
            'role'          => $data[0]['user_type'],
            'locale'        => $data[0]['locale'],
            'email'         => $data[0]['email'],
            'reg_date'      => $data[0]['reg_date'],
            'account_status'=> $data[0]['account_status'],
            'cf'            => $data[0]['cf'],
            'dob'           => $data[0]['dob'],
            'height'        => $data[0]['height'],
            'weight'        => $data[0]['weight'],
            'telefono'      => $data[0]['telefono'],
            'em_nome'       => $data[0]['em_nome'],
            'em_telefono'   => $data[0]['em_telefono'],
            'address'   => $data[0]['address'],
        ];
    }
}
