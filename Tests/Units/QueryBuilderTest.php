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

    public function testBindings()
    {
        $query = $this->queryBuilder->where('id', 7)->where('report_type', '>=', '100');
        self::assertIsArray($query->getPlaceholders());
        self::assertIsArray($query->getBindings());

        var_dump($query->getPlaceholders(), $query->getBindings());
        exit();
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

    public function testItCanPerformSelectQuery()
    {
        $results = $this->queryBuilder
            ->table('reports')
            ->select('*')
            ->where('id', 1)
            ->first();
        self::assertNotNull($results);
        self::assertSame(1, (int)$results->id);
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
