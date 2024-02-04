<?php

declare(strict_types=1);

use Easy\Annotation\Api\MApiRequestParamCollector;
use Easy\Annotation\Api\MApiResponseParamCollector;
use Easy\Annotation\DependProxyCollector;

return [
    'scan' => [
        'paths' => [
            BASE_PATH . '/app',
            BASE_PATH . '/api',
            BASE_PATH . '/plugin',
        ],
        // 初始化注解收集器
        'collectors' => [
            MApiRequestParamCollector::class,
            MApiResponseParamCollector::class,
            DependProxyCollector::class,
        ],
        'ignore_annotations' => [
            'mixin',
            'required',
        ],
    ],
];
