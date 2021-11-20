<?php

namespace Tests\Units;

use App\Database\MySQLiConnection;
use App\Database\MySQLiQueryBuilder;
use App\Database\PDOQueryBuilder;
use PHPUnit\Framework\TestCase;
use App\Database\QueryBuilder, App\Database\PDOConnection;
use App\Helpers\Config;
use App\Helpers\DBQueryBuilderFactory;

class QueryBuilderTest extends TestCase
{
    private $queryBuilder;


    public function setUp(): void
    {
        $this->queryBuilder = DBQueryBuilderFactory::make('database', 'pdo', ['db_name' => 'bug_tracker_testing']);
        $this->queryBuilder->getConnection()->beginTransaction();
        parent::setUp();
    }

    public function insertIntoTable()
    {
        $data = [
            'report_type' => 'Report Type 1',
            'message' => 'This is a dummy message',
            'email' => 'support@kaloy.ca',
            'link' => 'https://link.com',
            'created_at' => date('Y-m-d H:i:s')
        ];
        $id = $this->queryBuilder->table('reports')->create($data);
        return $id;
    }

    public function testItCanPerformSelectQuery()
    {
        $id = $this->insertIntoTable();
        $results = $this->queryBuilder
            ->table('reports')
            ->select('*')
            ->where('id', $id)
            ->first();



        self::assertNotNull($results);
        self::assertSame($id, $results->id);
    }


    public function testItCanCreateRecords()
    {
        $id = $this->insertIntoTable();
        // var_dump($id);
        // exit();
        self::assertNotNull($id);
    }

    public function testItCanPerformRawQuery()
    {
        $id = $this->insertIntoTable();
        $result = $this->queryBuilder->raw("SELECT * FROM reports")->get();
        // var_dump($result);
        // exit();
        self::assertNotNull($result);
    }



    public function testItCanPerformSelectQueryWithMultipleWhereClause()
    {
        $id = $this->insertIntoTable();
        $result = $this->queryBuilder
            ->table('reports')
            ->select('*')
            ->where('id', $id)
            ->where('report_type', 'Report Type 1')
            ->first();

        self::assertNotNull($result);
        self::assertSame($id, $result->id);
        self::assertSame('Report Type 1', $result->report_type);
    }

    public function testItCanFindById()
    {
        $id = $this->insertIntoTable();
        $result = $this->queryBuilder->select('*')->find($id);
        // var_dump($result);
        // exit();
        self::assertNotNull($result);
        self::assertSame($id, $result->id);
        self::assertSame('Report Type 1', $result->report_type);
    }

    public function testItCanFindByGivenValue()
    {
        $id = $this->insertIntoTable();
        $result = $this->queryBuilder->select('*')->findOneBy('report_type', 'Report Type 1');
        self::assertNotNull($result);
        self::assertSame($id, $result->id);
        self::assertSame('Report Type 1', $result->report_type);
    }

    public function testItCanUpdateGivenRecord()
    {
        $id = $this->insertIntoTable();

        $count = $this->queryBuilder->table('reports')->update([
            'report_type' => 'Report Type 1 updated'
        ])->where('id', $id)->count();
        self::assertEquals(1, $count);
        $result = $this->queryBuilder->select('*')->findOneBy('report_type', 'Report Type 1 updated');
        self::assertNotNull($result);
        self::assertSame($id, $result->id);
        self::assertSame('Report Type 1 updated', $result->report_type);
    }

    public function tearDown(): void
    {
        $this->queryBuilder->getConnection()->rollback();
        parent::tearDown();
        // 
    }
}
