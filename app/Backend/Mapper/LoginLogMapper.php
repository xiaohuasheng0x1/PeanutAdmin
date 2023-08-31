<?php
declare(strict_types=1);
namespace App\Backend\Mapper;

use App\Backend\Model\LoginLog;
use App\Common\Abstracts\AbstractMapper;
use Hyperf\Database\Model\Builder;

/**
 * Class UserMapper
 * @package App\System\Mapper
 */
class LoginLogMapper extends AbstractMapper
{
    /**
     * @var LoginLog
     */
    public $model;

    public function assignModel()
    {
        $this->model = LoginLog::class;
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

        if (!empty($params['username'])) {
            $query->where('username', 'like', '%'.$params['username'].'%');
        }

        if (!empty($params['status'])) {
            $query->where('status', $params['status']);
        }

        if (!empty($params['login_time']) && is_array($params['login_time']) && count($params['login_time']) == 2) {
            $query->whereBetween(
                'login_time',
                [ $params['login_time'][0] . ' 00:00:00', $params['login_time'][1] . ' 23:59:59' ]
            );
        }
        return $query;
    }
}