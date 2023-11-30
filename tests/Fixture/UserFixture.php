<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Test\Fixture;

use App\Domain\Users\Type\UserRoleType;
use App\Moebius\Definition;

/**
 * Fixture.
 */
class UserFixture
{
    /** @var string Table name */
    public $table = 'users';

    /**
     * Records.
     *
     * @var array<mixed> Records
     */
    public $records = [
        [
            'user_id' => 2,
            'f_name' => 'First Name',
            'l_name' => 'Last Name',
            'passwd' => 'aeae379a6e857728e44164267fdb7a0e27b205d757cc19899586c89dbb221930f1813d02ff93a661859bc17065eac4d6edf3c38a034e6283a84754d52917e5b0', // asdasd
            'email' => 'mail@address.com',
            'user_role' => Definition::ADMIN,
            'locale' => 'en_EN',
            'created_at' => '2019-01-09 14:05:19',
            'updated_at' => '2019-01-09 14:05:19',
        ],
        [
            'user_id' => 3,
            'f_name' => 'ajeje',
            'l_name' => 'brazof',
            'passwd' => 'aeae379a6e857728e44164267fdb7a0e27b205d757cc19899586c89dbb221930f1813d02ff93a661859bc17065eac4d6edf3c38a034e6283a84754d52917e5b0', // asdasd
            'email' => 'ajeje@example.com',
            'user_role' => Definition::ADMIN,
            'locale' => 'en_EN',
            'created_at' => '2019-01-09 14:05:19',
            'updated_at' => '2019-01-09 14:05:19',
        ],
    ];
}
