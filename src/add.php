<?php
require_once __DIR__ . '/../vendor/autoload.php';


use Throwable;
use App\Logger\Logger;
use App\Entity\BugReport;
use App\Database\QueryBuilder;
use App\Exception\BadRequestException;
use App\Helpers\DBQueryBuilderFactory;
use App\Repository\BugReportRepository;
use App\Helpers\App;

if (isset($_POST['add'])) {
    $reportType = $_POST['reportType'];
    $email = $_POST['email'];
    $link = $_POST['link'];
    $message = $_POST['message'];

    $bugReport = new BugReport();
    $bugReport->setReportType($reportType);
    $bugReport->setEmail($email);
    $bugReport->setMessage($message);
    $bugReport->setLink($link);

    $logger = new Logger();

    try {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = DBQueryBuilderFactory::make('database', 'pdo', ['db_name' => 'bug_tracker_testing']);
        /** @var BugReportRepository $repository */
        $repository = new BugReportRepository($queryBuilder);
        /** @var BugReport $newReport */
        $newReport = $repository->create($bugReport);
    } catch (Throwable $th) {
        $logger->critical($th->getMessage(), $_POST);
        throw new BadRequestException($th->getMessage(), [$th], 400);
    }

    $logger->info(
        'new bug report created',
        ['id' => $newReport->getId(), 'type' => $newReport->getReportType()]
    );
    // $bugReports = $repository->findAll($newReport->getId());
}
