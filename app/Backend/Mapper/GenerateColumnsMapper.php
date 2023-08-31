<?php

declare(strict_types=1);
namespace App\Backend\Mapper;

use App\Backend\Model\GenerateColumns;
use App\Common\Abstracts\AbstractMapper;
use Hyperf\Database\Model\Builder;

/**
 * 生成业务字段信息表查询类
 * Class GenerateColumnsMapper
 * @package App\Setting\Mapper
 */
class GenerateColumnsMapper extends AbstractMapper
{
    /**
     * @var GenerateColumns
     */
    public $model;

    public function assignModel()
    {
        $this->model = GenerateColumns::class;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        if ($params['table_id'] ?? false) {
            $query->where('table_id', (int) $params['table_id']);
        }
        return $query;
    }
}