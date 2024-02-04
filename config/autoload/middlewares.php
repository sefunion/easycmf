<?php

declare(strict_types=1);

use Hyperf\Validation\Middleware\ValidationMiddleware;
use Easy\Middlewares\CheckModuleMiddleware;

return [
    'http' => [
        CheckModuleMiddleware::class,
        ValidationMiddleware::class,
    ],
];
