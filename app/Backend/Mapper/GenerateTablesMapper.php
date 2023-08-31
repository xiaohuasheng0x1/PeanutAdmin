<?php

declare(strict_types=1);
namespace App\Backend\Mapper;

use App\Backend\Model\GenerateTables;
use App\Common\Abstracts\AbstractMapper;
use App\Common\Annotation\Transaction;
use Hyperf\Database\Model\Builder;

/**
 * 生成业务信息表查询类
 * Class GenerateTablesMapper
 * @package App\Setting\Mapper
 */
class GenerateTablesMapper extends AbstractMapper
{
    /**
     * @var GenerateTables
     */
    public $model;

    public function assignModel()
    {
        $this->model = GenerateTables::class;
    }

    /**
     * 删除业务信息表和字段信息表
     * @throws \Exception
     */
    #[Transaction]
    public function delete(array $ids): bool
    {
        /* @var GenerateTables $model */
        foreach ($this->model::query()->whereIn('id', $ids)->get() as $model) {
            if ($model) {
                $model->columns()->delete();
                $model->delete();
            }
        }
        return true;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        if (!empty($params['table_name'])) {
            $query->where('table_name', 'like', '%'.$params['table_name'].'%');
        }
        if (!empty($params['minDate']) && !empty($params['maxDate'])) {
            $query->whereBetween(
                'created_at',
                [$params['minDate'] . ' 00:00:00', $params['maxDate'] . ' 23:59:59']
            );
        }
        return $query;
    }
}