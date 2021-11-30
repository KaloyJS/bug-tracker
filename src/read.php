<?php

use App\Database\QueryBuilder;
use App\Helpers\DBQueryBuilderFactory;
use App\Repository\BugReportRepository;

/** @var QueryBuilder $queryBuilder */
$queryBuilder = DBQueryBuilderFactory::make('database', 'pdo',);
$repository = new BugReportRepository($queryBuilder);

$bugReports = $repository->findAll();
