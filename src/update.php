<?php
require_once __DIR__ . '/../vendor/autoload.php';


use Throwable;
use App\Logger\Logger;
use App\Entity\BugReport;
use App\Database\QueryBuilder;
use App\Exception\BadRequestException;
use App\Helpers\DBQueryBuilderFactory;
use App\Repository\BugReportRepository;


if (isset($_POST['update'])) {
    $id = $_POST['reportId'];
    $link = $_POST['link'];
    $message = $_POST['message'];
    $logger = new Logger();

    try {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = DBQueryBuilderFactory::make('database', 'pdo', ['db_name' => 'bug_tracker_testing']);
        /** @var BugReportRepository $repository */
        $repository = new BugReportRepository($queryBuilder);
        /** @var BugReport $bugReport */
        $bugReport = $repository->find($id);
        $bugReport->setMessage($message);
        $bugReport->setLink($link);
        $newReport = $repository->update($bugReport);
    } catch (Throwable $th) {
        $logger->critical($th->getMessage(), $_POST);
        throw new BadRequestException($th->getMessage(), [$th], 400);
    }

    $logger->info(
        'bug report updated',
        [
            'id' => $newReport->getId(),
            'link' => $newReport->getReportType(),
            'message' => $newReport->getMessage()
        ]
    );
    $bugReports = $repository->findAll();
}
