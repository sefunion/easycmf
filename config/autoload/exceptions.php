<?php

declare(strict_types=1);

use Hyperf\HttpServer\Exception\Handler\HttpExceptionHandler;
use Easy\Exception\Handler\AppExceptionHandler;
use Easy\Exception\Handler\NoPermissionExceptionHandler;
use Easy\Exception\Handler\NormalStatusExceptionHandler;
use Easy\Exception\Handler\TokenExceptionHandler;
use Easy\Exception\Handler\ValidationExceptionHandler;

return [
    'handler' => [
        'http' => [
            HttpExceptionHandler::class,
            ValidationExceptionHandler::class,
            TokenExceptionHandler::class,
            NoPermissionExceptionHandler::class,
            NormalStatusExceptionHandler::class,
            AppExceptionHandler::class,
        ],
    ],
];
