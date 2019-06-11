<?php
/**
 * This software was built by:
 * Daniel Tomé Fernández <danieltomefer@gmail.com>
 * GitHub: danitome24
 */
declare(strict_types=1);

namespace Facturini\Database\Mysqli;

use Facturini\Database\Connection;
use mysqli;

final class MysqliConnection implements Connection
{
    /** @var string */
    private $host;
    /** @var string */
    private $user;
    /** @var string */
    private $password;
    /** @var string */
    private $db;
    /** @var mysqli */
    private $connection;

    public static function create($host, $user, $password, $db): Connection
    {
        $self = new self($host, $user, $password, $db);
        $self->connect();

        return $self;
    }

    private function __construct($host, $user, $password, $db)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->db = $db;
    }

    private function connect(): void
    {
        if (!$dbi = mysqli_connect($this->host, $this->user, $this->password)) {
            die('error connection db');
        }
        mysqli_select_db($dbi, $this->db);
        $this->connection = $dbi;
    }

    public function connection(): mysqli
    {
        return $this->connection;
    }

    public function disconnect()
    {
        global $dbtype;
        switch ($dbtype) {
            case "MySQL":
                return @mysqli_close($this->connection);
                break;
            default:
                break;
        }
    }
}
