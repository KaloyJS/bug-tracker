<?php

declare(strict_types=1);

use App\Helpers\Config;
use App\Entity\BugReport;
use App\Repository\Repository;
use App\Database\PDOConnection;
use App\Database\MySQLiConnection;
use App\Exception\ExceptionHandler;
use App\Database\MySQLiQueryBuilder;
use App\Helpers\DBQueryBuilderFactory;
use App\Repository\BugReportRepository;
use App\Exception\DatabaseConnectionException;

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/src/Exception/exception.php';

// $queryBuilder = DBQueryBuilderFactory::make('database', 'mysqli', ['db_name' => 'bug_tracker_testing']);

// $bugReportRepository = new BugReportRepository($queryBuilder);

// function createBugReport(Repository $bugReportRepository): BugReport
// {
//     $bugReport = new BugReport();
//     $bugReport->setReportType('Type 2')
//         ->setLink('https://testing-link.com')
//         ->setMessage('This is a dummy message')
//         ->setEmail('email@test.com');

//     $newBugReport = $bugReportRepository->create($bugReport);
//     return $bugReportRepository->create($bugReport);
// }

// $bugReport = createBugReport($bugReportRepository);

// $id = $bugReport->getId();
// $bugReport = $bugReportRepository->find($id);
// $bugReport->setMessage('This is from update method')
//     ->setLink('https://newlink.com/image.png');
echo php_sapi_name();
