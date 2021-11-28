<?php
require_once __DIR__ . '/../vendor/autoload.php';


use Throwable;
use App\Logger\Logger;
use App\Entity\BugReport;
use App\Database\QueryBuilder;
use App\Exception\BadRequestException;
use App\Helpers\DBQueryBuilderFactory;
use App\Repository\BugReportRepository;


if (isset($_POST['delete'])) {
    $id = $_POST['reportId'];

    $logger = new Logger();

    try {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = DBQueryBuilderFactory::make('database', 'pdo', ['db_name' => 'bug_tracker_testing']);
        /** @var BugReportRepository $repository */
        $repository = new BugReportRepository($queryBuilder);
        /** @var BugReport $bugReport */
        $bugReport = $repository->find($id);
        $repository->delete($bugReport);
    } catch (Throwable $th) {
        $logger->critical($th->getMessage(), $_POST);
        throw new BadRequestException($th->getMessage(), [$th], 400);
    }

    $logger->info(
        'bug report deleted',
        [
            'id' => $id,
        ]
    );
    $bugReports = $repository->findAll();
}
