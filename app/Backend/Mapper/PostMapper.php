<?php

declare(strict_types = 1);
namespace App\Backend\Mapper;


use App\Backend\Model\Post;
use App\Common\Abstracts\AbstractMapper;
use Hyperf\Database\Model\Builder;

class PostMapper extends AbstractMapper
{
    /**
     * @var Post
     */
    public $model;

    public function assignModel()
    {
        $this->model = Post::class;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        if (!empty($params['name'])) {
            $query->where('name', 'like', '%'.$params['name'].'%');
        }
        if (!empty($params['code'])) {
            $query->where('code', $params['code']);
        }
        if (!empty($params['status'])) {
            $query->where('status', $params['status']);
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