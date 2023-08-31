<?php

declare(strict_types = 1);
namespace App\Backend\Mapper;

use App\Backend\Model\Notice;
use App\Common\Abstracts\AbstractMapper;
use Hyperf\Database\Model\Builder;

/**
 * 通知管理Mapper类
 */
class NoticeMapper extends AbstractMapper
{
    /**
     * @var Notice
     */
    public $model;

    public function assignModel()
    {
        $this->model = Notice::class;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        if (!empty($params['title'])) {
            $query->where('title', '=', $params['title']);
        }

        if (!empty($params['type'])) {
            $query->where('type', '=', $params['type']);
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