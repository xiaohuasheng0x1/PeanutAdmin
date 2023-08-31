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
use Hyperf\Database\Commands\ModelOption;
return [
    'default' => [
        'driver' => env('DB_DRIVER', 'mysql'),
        'host' => env('DB_HOST', 'localhost'),
        'database' => env('DB_DATABASE', 'hyperf'),
        'port' => env('DB_PORT', 3306),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', 'root'),
        'charset' => env('DB_CHARSET', 'utf8mb4'),
        'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
        'prefix' => env('DB_PREFIX', ''),
        'pool' => [
            'min_connections' => 1,
            'max_connections' => 20,
            'connect_timeout' => 10.0,
            'wait_timeout' => 3.0,
            'heartbeat' => -1,
            'max_idle_time' => (float) env('DB_MAX_IDLE_TIME', 60),
        ],
        'cache' => [
            'handler' => \Hyperf\ModelCache\Handler\RedisHandler::class,
            'cache_key' => 'PeanutAdmin:%s:m:%s:%s:%s',
            'prefix' => 'model-cache',
            'ttl' => 86400 * 7,
            'empty_model_ttl' => 60,
            'load_script' => true,
            'use_default_value' => false,
        ],
        'commands' => [
            'gen:model' => [
                'path' => 'app/Backend/Model',
                'force_casts' => true,
                'inheritance' => 'PaModel',
                'uses' => 'App\Common\PaModel',
                'with_comments' => true,
                'refresh_fillable' => true,
                'visitors' => [
                    Hyperf\Database\Commands\Ast\ModelRewriteKeyInfoVisitor::class,
                    Hyperf\Database\Commands\Ast\ModelRewriteTimestampsVisitor::class,
                    Hyperf\Database\Commands\Ast\ModelRewriteSoftDeletesVisitor::class,
//                    Hyperf\database\Commands\Ast\ModelRewriteGetterSetterVisitor::class,
                ],
            ],
        ],
    ],
];
