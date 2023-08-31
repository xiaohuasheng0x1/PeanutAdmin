<?php

declare(strict_types=1);
namespace App\Backend\Mapper;


use App\Backend\Model\CrontabLog;
use App\Common\Abstracts\AbstractMapper;
use Hyperf\Database\Model\Builder;

class CrontabLogMapper extends AbstractMapper
{
    /**
     * @var CrontabLog
     */
    public $model;

    public function assignModel()
    {
        $this->model = CrontabLog::class;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        if ($params['crontab_id'] ?? false) {
            $query->where('crontab_id', $params['crontab_id']);
        }
        return $query;
    }

}