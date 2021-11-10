<?php

declare(strict_types=1);

namespace App\Exception;

use App\Helpers\App;
use App\Helpers\Utility;
use Throwable, ErrorException;

class ExceptionHandler
{

    public function handle(Throwable $exception): void
    {
        $application = new App;

        if ($application->isDebugMode()) {
            Utility::printArr($exception);
        } else {
            echo "This should not have happened, please try again";
        }
        exit;
    }

    public function convertWarningsAndNoticesToException($severity, $message, $file, $line)
    {
        throw new ErrorException($message, $severity, $severity, $file, $line);
    }
}
