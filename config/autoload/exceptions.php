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

return [
    'handler' => [
        'http' => [
            Hyperf\HttpServer\Exception\Handler\HttpExceptionHandler::class,
            \App\Common\Exception\Handler\ValidationExceptionHandler::class,
            \App\Common\Exception\Handler\TokenExceptionHandler::class,
            \App\Common\Exception\Handler\NoPermissionExceptionHandler::class,
            \App\Common\Exception\Handler\NormalStatusExceptionHandler::class,
            \App\Common\Exception\Handler\AppExceptionHandler::class,
        ],
    ],
];
