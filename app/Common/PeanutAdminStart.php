<?php


declare(strict_types=1);
namespace App\Common;

use Hyperf\Framework\Bootstrap\ServerStartCallback;

class PeanutAdminStart extends ServerStartCallback
{
    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function beforeStart()
    {
        $console = console();
        $console->info('Peanut-Admin start success...');
        str_contains(PHP_OS, 'CYGWIN') && $console->info('current booting the user: ' . shell_exec('whoami'));
    }
}