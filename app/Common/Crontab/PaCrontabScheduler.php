<?php


declare(strict_types=1);
namespace App\Common\Crontab;


use App\Common\Crontab\PaCrontabManage;

class PaCrontabScheduler
{
    /**
     * PaCrontabManage
     */
    protected PaCrontabManage $crontabManager;

    /**
     * \SplQueue
     */
    protected \SplQueue $schedules;

    /**
     * PaCrontabScheduler constructor.
     * @param PaCrontabManage $crontabManager
     */
    public function __construct(PaCrontabManage $crontabManager)
    {
        $this->schedules = new \SplQueue();
        $this->crontabManager = $crontabManager;
    }

    public function schedule(): \SplQueue
    {
        foreach ($this->getSchedules() ?? [] as $schedule) {
            $this->schedules->enqueue($schedule);
        }
        return $this->schedules;
    }

    protected function getSchedules(): array
    {
        return $this->crontabManager->getCrontabList();
    }
}
