<?php

declare(strict_types=1);

use App\System\Middleware\WsAuthMiddleware;
use Hyperf\HttpServer\Router\Router;

Router::get('/', function () {
    return 'welcome use easycmf';
});

Router::get('/favicon.ico', function () {
    return '';
});

// 消息ws服务器
Router::addServer('message', function () {
    Router::get('/message.io', 'App\System\Controller\ServerController', [
        'middleware' => [WsAuthMiddleware::class],
    ]);
});
