<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

use Hyperf\HttpServer\Router\Router;

Router::get('/', function () {
    return 'welcome use peanutAdmin';
});

Router::get('/favicon.ico', function () {
    return '';
});

// 消息ws服务器
Router::addServer('message', function () {
    Router::get('/message.io', 'App\Backend\Controller\ServerController', [
        'middleware' => [ \App\Backend\Middleware\WsAuthMiddleware::class ]
    ]);
});
