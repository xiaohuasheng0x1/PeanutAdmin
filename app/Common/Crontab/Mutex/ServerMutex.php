<?php


declare(strict_types=1);
namespace App\Common\Crontab\Mutex;

use App\Common\Crontab\PaCrontab;

interface ServerMutex
{
    /**
     * Attempt to obtain a server mutex for the given crontab.
     * @param PaCrontab $crontab
     * @return bool
     */
    public function attempt(PaCrontab $crontab): bool;

    /**
     * Get the server mutex for the given crontab.
     * @param PaCrontab $crontab
     * @return string
     */
    public function get(PaCrontab $crontab): string;
}
