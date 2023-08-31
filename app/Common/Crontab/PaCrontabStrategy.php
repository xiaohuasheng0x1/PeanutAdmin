<?php


declare(strict_types=1);
namespace App\Common\Crontab;

use Carbon\Carbon;
use App\Common\Crontab\PaCrontab;
use App\Common\Crontab\PaCrontabManage;
use App\Common\Crontab\PaExecutor;
use Hyperf\Di\Annotation\Inject;

use function Hyperf\Coroutine\co;

class PaCrontabStrategy
{
    /**
     * PaCrontabManage
     */
    #[Inject]
    protected PaCrontabManage $mineCrontabManage;

    /**
     * PaExecutor
     */
    #[Inject]
    protected PaExecutor $executor;

    /**
     * @param PaCrontab $crontab
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function dispatch(PaCrontab $crontab)
    {
        co(function() use($crontab) {
            if ($crontab->getExecuteTime() instanceof Carbon) {
                $wait = $crontab->getExecuteTime()->getTimestamp() - time();
                $wait > 0 && \Swoole\Coroutine::sleep($wait);
                $this->executor->execute($crontab);
            }
        });
    }

    /**
     * 执行一次
     * @param PaCrontab $crontab
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function executeOnce(PaCrontab $crontab)
    {
        co(function() use($crontab) {
            $this->executor->execute($crontab);
        });
    }
}