<?php

namespace App\Exception;

use JetBrains\PhpStorm\Pure;
use Throwable;

class ImportException extends \Exception
{
    const ERROR_NOT_FOUND = 1;
    const ERROR_MALFORMED = 2;
    const ERROR_INVALID = 3;
}
