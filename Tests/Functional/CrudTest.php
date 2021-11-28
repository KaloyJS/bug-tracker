<?php

namespace Tests\Functional;

use App\Entity\BugReport;
use App\Helpers\DBQueryBuilderFactory;
use App\Repository\BugReportRepository;
use PHPUnit\Framework\TestCase;
use App\Helpers\HttpClient;


class CrudTest extends TestCase
{
    /** @var QueryBuilder $querybuilder */
    private $queryBuilder;
    /** @var BugReportRepository $repository */
    private $repository;
    private $client;

    public function setUp(): void
    {
        // define('PHPUNIT_RUNNING2', true);
        $this->queryBuilder = DBQueryBuilderFactory::make('database', 'pdo', ['db_name' => 'bug_tracker_testing']);
        // $this->queryBuilder->beginTransaction();
        $this->repository = new BugReportRepository($this->queryBuilder);
        $this->client = new HttpClient();
        parent::setUp();
    }

    public function testItCanCreateReportUsingPostRequest()
    {
        $postData = $this->getPostData(['add' => true]);
        $response = $this->client->post("http://localhost/bug-tracker/src/add.php", $postData);

        $response = json_decode($response);
        self::assertEquals(200, $response->statusCode);

        $result = $this->repository->findBy([
            ["report_type", '=', "Audio"],
            ["email", '=', "test@example.com"],
            ["link", '=', "https://example.com"],
        ]);

        /** @var BugReport $bugReport */
        $bugReport = $result[0] ?? [];

        self::assertInstanceOf(BugReport::class, $bugReport);
        self::assertSame('Audio', $bugReport->getReportType());
        self::assertSame("test@example.com", $bugReport->getEmail());
        self::assertSame("https://example.com", $bugReport->getLink());
        return $bugReport;
    }

    /** @depends testItCanCreateReportUsingPostRequest */
    public function testItCanUpdateReportUsingPostRequest(BugReport $bugReport)
    {
        $postData = $this->getPostData([
            'update' => true,
            "message" => "the video on PHP OOP has audio issues, please check and fix it",
            "link" => "https://updated.com",
            "reportId" => $bugReport->getId(),
        ]);
        $response = $this->client->post("http://localhost/bug-tracker/src/update.php", $postData);

        $response = json_decode($response);
        self::assertEquals(200, $response->statusCode);

        /** @var BugReport $bugReport */
        $bugReport = $this->repository->find($bugReport->getId());
        // var_dump($result);
        // exit();

        self::assertInstanceOf(BugReport::class, $bugReport);
        self::assertSame("the video on PHP OOP has audio issues, please check and fix it", $bugReport->getMessage());
        self::assertSame("https://updated.com", $bugReport->getLink());
        return $bugReport;
    }

    /** @depends testItCanUpdateReportUsingPostRequest */
    public function testItCanDeleteReportUsingPostRequest(BugReport $bugReport)
    {

        $postData = [
            'delete' => true,
            "reportId" => $bugReport->getId(),
        ];
        $response = $this->client->post("http://localhost/bug-tracker/src/delete.php", $postData);

        $response = json_decode($response);
        self::assertEquals(200, $response->statusCode);

        /** @var BugReport $bugReport */
        $result = $this->repository->find($bugReport->getId());
        self::assertNull($result);
    }



    private function getPostData(array $options = []): array
    {
        return array_merge([
            "reportType" => "Audio",
            "message" => "the video on xxx has audio issues, please check and fix it",
            "email" => "test@example.com",
            "link" => "https://example.com",
        ], $options);
    }

    public function tearDown(): void
    {
        // $this->queryBuilder->getConnection()->rollback();
        parent::tearDown();
        // 
    }
}
