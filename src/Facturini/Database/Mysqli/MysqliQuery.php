<?php
/**
 * This software was built by:
 * Daniel Tomé Fernández <danieltomefer@gmail.com>
 * GitHub: danitome24
 */
declare(strict_types=1);

namespace Facturini\Database\Mysqli;

use Facturini\Database\Connection;
use Facturini\Database\Query;
use Facturini\Database\ResultSet;

final class MysqliQuery implements Query
{
    private $connection;

    private $debugMode;

    public function __construct(Connection $connection, $debugMode = false)
    {
        $this->connection = $connection;
        $this->debugMode = $debugMode;
        $this->query('SET NAMES utf8');
    }

    /**
     * sql_query($query, $id) executes an SQL statement, returns a ResultSet
     * @param $query
     * @return bool|ResultSet
     */
    public function query($query)
    {
        if ($this->debugMode) {
            echo 'SQL query: ' . str_replace(',', ', ', $query) . '<BR>';
        }

        if ($result = mysqli_query($this->connection->connection(), $query)) {
            return new MysqliResultSet($result);
        }

        return false;
    }
}
