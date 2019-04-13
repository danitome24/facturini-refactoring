<?php
/**
 * This software was built by:
 * Daniel Tomé Fernández <danieltomefer@gmail.com>
 * GitHub: danitome24
 */
declare(strict_types=1);

namespace Facturini\Database\Mysqli;

use Facturini\Database\ResultSet;

final class MysqliResultSet implements ResultSet
{
    private $result;

    public function __construct($result)
    {
        $this->result = $result;
    }

    /**
     * sql_num_rows($res)
     * given a result identifier, returns the number of affected rows
     */
    public function numberOfResults(): int
    {
        global $dbtype;
        switch ($dbtype) {
            case "MySQL":
                return mysqli_num_rows($this->result);
                break;
            default:
                break;
        }
    }

    /**
     * sql_fetch_array($res,$row)
     * given a result identifier, returns an associative array
     * with the resulting row using field names as keys.
     * Needs also a row number for compatibility with PostgreSQL.
     */
    public function inArray(): ?array
    {
        global $dbtype;
        switch ($dbtype) {
            case "MySQL":
                return mysqli_fetch_array($this->result);
                break;
            default:
                break;

        }
    }
}
