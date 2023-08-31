<?php


declare(strict_types=1);
namespace App\Common\Crontab\Mutex;

use App\Common\Crontab\PaCrontab;

interface TaskMutex
{
    /**
     * Attempt to obtain a task mutex for the given crontab.
     * @param PaCrontab $crontab
     * @return bool
     */
    public function create(PaCrontab $crontab): bool;

    /**
     * Determine if a task mutex exists for the given crontab.
     * @param PaCrontab $crontab
     * @return bool
     */
    public function exists(PaCrontab $crontab): bool;

    /**
     * Clear the task mutex for the given crontab.
     * @param PaCrontab $crontab
     */
    public function remove(PaCrontab $crontab);
}
