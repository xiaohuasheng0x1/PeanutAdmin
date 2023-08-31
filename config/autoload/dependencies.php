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
    Hyperf\Database\Commands\Ast\ModelUpdateVisitor::class => \App\Common\PaModelVisitor::class,
    Hyperf\HttpServer\CoreMiddleware::class => \App\Common\Middlewares\HttpCoreMiddleware::class,
    App\Common\Interfaces\UserServiceInterface::class => \App\Backend\Service\Dependencies\UserAuthService::class,
];
