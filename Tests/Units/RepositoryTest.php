<?php

declare(strict_types=1);

namespace Tests\Units;

use App\Helpers\DBQueryBuilderFactory;
use App\Database\QueryBuilder;
use App\Entity\BugReport;
use App\Repository\BugReportRepository;
use PHPUnit\Framework\TestCase;

class RepositoryTest extends TestCase
{
    /** @var QueryBuilder $queryBuilder */
    private $queryBuilder;
    private $bugReportRepository;

    public function setUp(): void
    {
        $this->queryBuilder = DBQueryBuilderFactory::make('database', 'pdo', ['db_name' => 'bug_tracker_testing']);
        $this->queryBuilder->beginTransaction();
        $this->bugReportRepository = new BugReportRepository($this->queryBuilder);
        parent::setUp();
    }

    public function createBugReport(): BugReport
    {
        $bugReport = new BugReport();
        $bugReport->setReportType('Type 2')
            ->setLink('https://testing-link.com')
            ->setMessage('This is a dummy message')
            ->setEmail('email@test.com');

        $newBugReport = $this->bugReportRepository->create($bugReport);
        return $this->bugReportRepository->create($bugReport);
    }

    public function testItCanCreateRecordWithEntity()
    {
        $newBugReport = $this->createBugReport();
        self::assertInstanceOf(BugReport::class, $newBugReport);
        self::assertSame('Type 2', $newBugReport->getReportType());
        self::assertSame('https://testing-link.com', $newBugReport->getLink());
        self::assertSame('This is a dummy message', $newBugReport->getMessage());
        self::assertSame('email@test.com', $newBugReport->getEmail());
        self::assertNotNull($newBugReport->getId());
    }

    public function testItCanUpdateAGivenEntity()
    {
        $newBugReport = $this->createBugReport();
        $bugReport = $this->bugReportRepository->find($newBugReport->getId());
        $bugReport->setMessage('This is from update method')
            ->setLink('https://newlink.com/image.png');
        $updatedReport = $this->bugReportRepository->update($bugReport);
        self::assertInstanceOf(BugReport::class, $updatedReport);
        self::assertSame('https://newlink.com/image.png', $updatedReport->getLink());
        self::assertSame('This is from update method', $updatedReport->getMessage());
    }

    public function testItCanDeleteAGivenEntity()
    {
        $newBugReport = $this->createBugReport();
        $this->bugReportRepository->delete($newBugReport);
        $bugReport = $this->bugReportRepository->find($newBugReport->getId());
        self::assertNull($bugReport);
    }

    public function testItCanFindByMultipleConditions()
    {
        $newBugReport = $this->createBugReport();
        $foundBugReport = $this->bugReportRepository->findBy([
            ["email", '=', 'email@test.com'],
            ['report_type', "=", "Type 2"]
        ]);
        // var_dump($foundBugReport);
        // exit;
        self::assertIsArray($foundBugReport);
        $bugReport = $foundBugReport[0];
        self::assertSame("Type 2", $bugReport->getReportType());
        self::assertSame('email@test.com', $bugReport->getEmail());
    }

    public function tearDown(): void
    {
        $this->queryBuilder->getConnection()->rollback();
        parent::tearDown();
    }
}
