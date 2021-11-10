<?php

declare(strict_types=1);

use App\Exception\ExceptionHandler;

require_once __DIR__ . '/vendor/autoload.php';



set_error_handler([new \App\Exception\ExceptionHandler(), 'handle']);
set_exception_handler([new \App\Exception\ExceptionHandler(), 'handle']);


$config = \App\Helpers\Config::getFileContent('yryryeryr');
var_dump($config);

$application = new \App\Helpers\App();
echo $application->getServerTime()->format('Y-m-d H:i:s') . PHP_EOL;
echo $application->getLogPath() . PHP_EOL;
echo $application->getEnvironment() . PHP_EOL;
echo $application->isDebugMode() . PHP_EOL;

if ($application->isRunningFromConsole()) {
    echo "from console";
} else {
    echo "from browser";
}
