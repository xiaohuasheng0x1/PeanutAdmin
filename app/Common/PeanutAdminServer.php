<?php
declare(strict_types=1);
namespace App\Common;

use Hyperf\HttpServer\Server;

class PeanutAdminServer extends Server
{
    protected ?string $serverName = 'peanutAdmin';

    public function onRequest($request, $response): void
    {
        parent::onRequest($request, $response);
    }
}
