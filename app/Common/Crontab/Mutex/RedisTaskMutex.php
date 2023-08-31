<?php


declare(strict_types=1);
namespace App\Common\Crontab\Mutex;

use App\Common\Crontab\Mutex\TaskMutex;
use Hyperf\Redis\RedisFactory;
use App\Common\Crontab\PaCrontab;

class RedisTaskMutex implements TaskMutex
{
    /**
     * @var RedisFactory
     */
    private $redisFactory;

    public function __construct(RedisFactory $redisFactory)
    {
        $this->redisFactory = $redisFactory;
    }

    /**
     * Attempt to obtain a task mutex for the given crontab.
     * @param PaCrontab $crontab
     * @return bool
     */
    public function create(PaCrontab $crontab): bool
    {
        return (bool) $this->redisFactory->get($crontab->getMutexPool())->set(
            $this->getMutexName($crontab),
            $crontab->getName(),
            ['NX', 'EX' => $crontab->getMutexExpires()]
        );
    }

    /**
     * Determine if a task mutex exists for the given crontab.
     * @param PaCrontab $crontab
     * @return bool
     */
    public function exists(PaCrontab $crontab): bool
    {
        return (bool) $this->redisFactory->get($crontab->getMutexPool())->exists(
            $this->getMutexName($crontab)
        );
    }

    /**
     * Clear the task mutex for the given crontab.
     * @param PaCrontab $crontab
     */
    public function remove(PaCrontab $crontab)
    {
        $this->redisFactory->get($crontab->getMutexPool())->del(
            $this->getMutexName($crontab)
        );
    }

    protected function getMutexName(PaCrontab $crontab): string
    {
        return 'framework' . DIRECTORY_SEPARATOR . 'crontab-' . sha1($crontab->getName() . $crontab->getRule());
    }
}
