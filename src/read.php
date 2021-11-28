<?php

use App\Database\QueryBuilder;
use App\Helpers\DBQueryBuilderFactory;
use App\Repository\BugReportRepository;

/** @var QueryBuilder $queryBuilder */
$queryBuilder = DBQueryBuilderFactory::make('database', 'pdo', ['db_name' => 'bug_tracker_testing']);
$repository = new BugReportRepository($queryBuilder);

$bugReports = $repository->findAll();
