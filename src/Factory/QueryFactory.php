<?php

namespace App\Factory;

use Cake\Database\Connection;
use Cake\Database\Query;
use RuntimeException;

/**
 * Factory.
 */
final class QueryFactory
{
    private Connection $connection;

    /**
     * The constructor.
     *
     * @param Connection $connection The database connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Create a new 'select' query for the given table.
     *
     * @param string $table The table name
     *
     * @throws RuntimeException
     *
     * @return Query A new select query
     */
    public function newSelect(array $fields, array $table): Query
    {
        return $this->connection->selectQuery($fields, $table);
    }


    /**
     * Create an 'update' statement for the given table.
     *
     * @param string $table The table to update rows from
     * @param array $data The values to be updated
     *
     * @return Query The new update query
     */
    public function newUpdate(string $table, array $data): Query
    {
        return $this->connection->updateQuery($table, $data);
    }

    /**
     * Create an 'update' statement for the given table.
     *
     * @param string $table The table to update rows from
     * @param array<mixed> $data The values to be updated
     *
     * @return Query The new insert query
     */
    public function newInsert(string $table, array $data): Query
    {
        return $this->connection->insertQuery($table, $data);
    }

    /**
     * Create a 'delete' query for the given table.
     *
     * @param string $table The table to delete from
     *
     * @return Query A new delete query
     */
    public function newDelete(string $table): Query
    {
        return $this->connection->deleteQuery($table);
    }

    public function rawQuery($q)
    {
        return $this->connection->execute($q)->fetchAll('assoc');
    }
}