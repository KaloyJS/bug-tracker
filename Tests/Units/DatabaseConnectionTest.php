<?php

namespace Tests\Units;

use App\Contracts\DatabaseConnectionInterface;
use App\Database\PDOConnection, App\Database\MySQLiConnection;
use App\Helpers\Config;
use PHPUnit\Framework\TestCase;

class DatabaseConnectionTest extends TestCase
{
    // Test to see if class throws a MissingArgumentException exception when credentials array is empty
    public function testItThrowsMissingArgumentExceptionWithWrongCredentialsKeys()
    {
        $this->expectException(\App\Exception\MissingArgumentException::class);
        $credentials = [];
        $pdoHandler = new PDOConnection($credentials);
    }

    public function testItCanConnectToDatabaseWithPdoApi()
    {
        $credentials = $this->getCredentials('pdo');
        $pdoHandler = (new PDOConnection($credentials))->connect();
        self::assertInstanceOf(DatabaseConnectionInterface::class, $pdoHandler);
        return $pdoHandler;
    }

    /** @depends testItCanConnectToDatabaseWithPdoApi */
    public function testItIsAValidPdoConnection(DatabaseConnectionInterface $handler)
    {
        // expects a value from previous method
        self::assertInstanceOf(\PDO::class, $handler->getConnection());
    }

    public function testItCanConnectToDatabaseWithMySqliApi()
    {
        $credentials = $this->getCredentials('pdo');
        $handler = (new MySQLiConnection($credentials))->connect();
        self::assertInstanceOf(DatabaseConnectionInterface::class, $handler);
        return $handler;
    }

    /** @depends testItCanConnectToDatabaseWithMySqliApi */
    public function testItIsAValidMysqliConnection(DatabaseConnectionInterface $handler)
    {
        // expects a value from previous method
        self::assertInstanceOf(\mysqli::class, $handler->getConnection());
    }

    private function getCredentials(string $type)
    {
        return array_merge(
            Config::get('database', $type),
            ['db_name' => 'bug_tracker_testing']
        );
    }
}
