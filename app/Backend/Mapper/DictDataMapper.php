<?php
declare(strict_types=1);
namespace App\Backend\Mapper;

use App\Backend\Model\DictData;
use App\Common\Abstracts\AbstractMapper;
use Hyperf\Database\Model\Builder;

/**
 * Class UserMapper
 * @package App\System\Mapper
 */
class DictDataMapper extends AbstractMapper
{
    /**
     * @var DictData
     */
    public $model;

    public function assignModel()
    {
        $this->model = DictData::class;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        if (!empty($params['type_id'])) {
            $query->where('type_id', $params['type_id']);
        }
        if (!empty($params['code'])) {
            $query->where('code', $params['code']);
        }
        if (!empty($params['value'])) {
            $query->where('value', 'like', '%'.$params['value'].'%');
        }
        if (!empty($params['label'])) {
            $query->where('label', 'like', '%'.$params['label'].'%');
        }
        if (!empty($params['status'])) {
            $query->where('status', $params['status']);
        }

        return $query;
    }
}