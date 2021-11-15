<?php

namespace Tests\Units;

use PHPUnit\Framework\TestCase;
use App\Database\QueryBuilder, App\Database\PDOConnection;
use App\Helpers\Config;

class QueryBuilderTest extends TestCase
{
    private $queryBuilder;


    public function setUp(): void
    {
        $pdo = new PDOConnection(
            array_merge(
                Config::get('database', 'pdo'),
                ['db_name' => 'bug_tracker_testing']
            )
        );
        $this->queryBuilder = new QueryBuilder($pdo->connect());
        parent::setUp();
    }

    public function testItCanPerformSelectQuery()
    {
        $results = $this->queryBuilder
            ->table('reports')
            ->select('*')
            ->where('id', 1);

        var_dump($results->query);
        exit();

        self::assertNotNull($results);
        self::assertSame(1, (int)$results->id);
    }


    public function testItCanCreateRecords()
    {
        $id = $this->queryBuilder->table('reports')->create($data);
        self::assertNotNull($id);
    }

    public function testItCanPerformRawQuery()
    {
        $result = $this->queryBuilder->raw("SELECT * FROM reports");
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
        self::assertSame(1, (int)$result->id);
        self::assertSame('Report Type 1', $result->report_type);
    }
}
