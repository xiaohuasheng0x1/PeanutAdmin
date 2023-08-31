<?php
declare(strict_types=1);

namespace App\Backend\Crontab;

use App\Backend\Model\LoginLog;
use App\Backend\Model\OperLog;
use App\Backend\Model\QueueLog;
use App\Common\Annotation\Transaction;

class ClearLogCrontab
{
    /**
     * 清理所有日志
     * @return string
     */
    #[Transaction]
    public function execute(): string
    {
        OperLog::truncate();
        LoginLog::truncate();
        QueueLog::truncate();

        return 'Clear logs successfully';
    }
}