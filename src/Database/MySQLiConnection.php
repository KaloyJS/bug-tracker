<?php

namespace App\Database;

use App\Contracts\DatabaseConnectionInterface;
use App\Exception\DatabaseConnectionException;
use mysqli, mysqli_driver, Throwable;

class MySQLiConnection extends AbstractConnection implements DatabaseConnectionInterface
{
    const REQUIRED_CONNECTION_KEYS = [
        'host',
        'db_name',
        'db_username',
        'db_user_password',
        'default_fetch',
    ];

    protected function parseCredentials(array $credentials): array
    {
        return [
            $credentials['host'],
            $credentials['db_username'],
            $credentials['db_user_password'],
            $credentials['db_name'],
        ];
    }

    public function connect(): MySQLiConnection
    {
        $driver = new mysqli_driver;
        // $driver->report_mode = MYSQL_REPORT_STRICT | MYSQL_ERROR;
        $credentials = $this->parseCredentials($this->credentials);
        try {
            $this->connection = new mysqli(...$credentials);
        } catch (Throwable $ex) {
            throw new DatabaseConnectionException($ex->getMessage(), $this->credentials, 500);
        }
        return $this;
    }

    public function getConnection(): mysqli
    {
        return $this->connection;
    }
}
