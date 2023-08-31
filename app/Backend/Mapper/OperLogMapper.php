<?php


namespace App\Backend\Mapper;


use App\Backend\Model\OperLog;
use App\Common\Abstracts\AbstractMapper;
use Hyperf\Database\Model\Builder;

class OperLogMapper extends AbstractMapper
{
    /**
     * @var OperLog
     */
    public $model;

    public function assignModel()
    {
        $this->model = OperLog::class;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        if (!empty($params['ip'])) {
            $query->where('ip', $params['ip']);
        }
        if (!empty($params['service_name'])) {
            $query->where('service_name', 'like', '%'.$params['service_name'].'%');
        }
        if (!empty($params['username'])) {
            $query->where('username', 'like', '%'.$params['username'].'%');
        }
        if (!empty($params['created_at']) && is_array($params['created_at']) && count($params['created_at']) == 2) {
            $query->whereBetween(
                'created_at',
                [ $params['created_at'][0] . ' 00:00:00', $params['created_at'][1] . ' 23:59:59' ]
            );
        }
        return $query;
    }

}