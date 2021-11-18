<?php

namespace Tests\Units;

use App\Database\MySQLiConnection;
use App\Database\MySQLiQueryBuilder;
use App\Database\PDOQueryBuilder;
use PHPUnit\Framework\TestCase;
use App\Database\QueryBuilder, App\Database\PDOConnection;
use App\Helpers\Config;

class QueryBuilderTest extends TestCase
{
    private $queryBuilder;


    public function setUp(): void
    {
        $pdo = new MySQLiConnection(
            array_merge(
                Config::get('database', 'mysqli'),
                ['db_name' => 'bug_tracker_testing']
            )
        );
        $this->queryBuilder = new MySQLiQueryBuilder($pdo->connect());
        parent::setUp();
    }

    public function testItCanPerformSelectQuery()
    {
        $results = $this->queryBuilder
            ->table('reports')
            ->select('*')
            ->where('id', 2)
            ->first();


        self::assertNotNull($results);
        self::assertSame(2, (int)$results->id);
    }


    public function testItCanCreateRecords()
    {
        $data = [
            'report_type' => 'Report Type 1',
            'message' => 'This is a dummy message',
            'email' => 'support@kaloy.ca',
            'link' => 'https://link.com',
            'created_at' => date('Y-m-d H:i:s')
        ];
        $id = $this->queryBuilder->table('reports')->create($data);
        // var_dump($id);
        // exit();
        self::assertNotNull($id);
    }

    public function testItCanPerformRawQuery()
    {
        $result = $this->queryBuilder->raw("SELECT * FROM reports")->get();
        self::assertNotNull($result);
    }



    public function testItCanPerformSelectQueryWithMultipleWhereClause()
    {
        $result = $this->queryBuilder
            ->table('reports')
            ->select('*')
            ->where('id', 1)
            ->where('report_type', '=', 'Report Type 1')
            ->first();
        self::assertNotNull($result);
        self::assertSame(2, (int)$result->id);
        self::assertSame('Report Type 1', $result->report_type);
    }
}
