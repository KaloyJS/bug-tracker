<?php

declare(strict_types=1);

use App\Exception\ExceptionHandler;

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/src/Exception/exception.php';

$logger = new \App\Logger\Logger();

$logger->log(\App\Logger\LogLevel::EMERGENCY, 'There is an emergency');

$logger->info('User account created successfully', ['id' => 5]);
